<template>
    <tree
            :treeData="treeData1"
            :options="options1"
            @node-click="itemClick1"
            :key="3"

    />
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import Tree from './tree/tree.vue';

    Vue.use(Tree)

    const NodesTree = {
        name: 'NodesTree',
        data: function () {
            return {
                options1: {
                    showCheckbox: false,
                    halfCheckedStatus: false, //控制父框是否需要半钩状态

                    lazy: true,
                    load: this.loadingChild,

                    rootName: 'Мир',

                    iconClass: {
                        close: 'icon-youjiantou',
                        open: 'icon-xiajiantou',
                        add: 'icon-add'
                    },
                    iconStyle: {
                        color: '#108ee9'
                    },

                    dynamicAdd: true,
                    // function  handle display add button
                    // return true or false
                    dynamicAddFilter: (node) => {
                        if (node.type === 1 || node.type === 2) {
                            return true
                        }
                        return false
                    },
                    // function handle add node; the new node must have `dynamicAdd` property
                    // the tree component rely on this show editor
                    // return Promise
                    dynamicAddNode: this.addNode,
                    // function handle save node; the new node must have `dynamicSaveNode` property
                    // the tree component rely on this save node
                    // return Promise
                    dynamicSaveNode: this.saveNode,
                    // function handle
                    // return String
                    leafIcon: this.leafIcon


                },
                treeData1: []
            }
        },
        mounted () {
            this.loadTreeData();
        },
        methods: {
            /**
             * generate key 0-1-2-3
             * this is very important function for now module
             * @param treeData
             * @param parentKey
             * @returns {Array}
             */
            generateKey (treeData = [], parentKey) {
                treeData = treeData.map((item, i) => {
                    item.key = parentKey + '-' + i.toString();

                    if (item.hasOwnProperty('children') && item.children.length > 0) {
                        this.generateKey(item.children, item.key)
                    }

                    return item;
                })
                return treeData;
            },
            /**
             * get parent node
             * @param node { Object }
             * @param treeData { Array }
             * @returns { Object }
             */
            getParentNode (node, treeData) {
                let tem;
                let postions = node.key.split('-');

                for (let [index, item] of postions.entries()) {
                    switch (index) {
                        case 0: //
                            break;
                        case 1:
                            tem = treeData[item];
                            break;
                        default:
                            tem = tem.children[item];
                    }
                }
                return tem
            },
            loadTreeData: async function () {
                try {
                    let treeData = await axios.get('http://localhost/getTreeData',
                        {
                            params: {
                                parentNodeId: 1
                            },
                            responseType: 'json'
                        });

                    console.log(treeData.data);
                    this.treeData1 = treeData.data
                    Promise.resolve(treeData.data);
                } catch (e) {
                    console.log('error=' + e);
                    Promise.reject(e);
                }
            },
            async loadingChild (node, index) {
                try {
                    let data = await axios.get('http://localhost/getTreeData', {
                        params: {
                            parentNodeId: node.id
                        },
                        responseType: 'json'
                    });                           
                    
                    let tem = this.getParentNode(node, this.treeData1)
                    
                    Vue.set(node, 'children', data.data);
                    Promise.resolve(data);
                } catch (e) {
                    Promise.reject(e);
                }
            },

            itemClick1 (node) {
                console.log(node.key);
            },
            async addNode (item) {
                let parent = this.getParentNode(item, this.treeData1)
                let node = {
                    id: 2,
                    label: '一级节点',
                    open: false,
                    checked: false,
                    nodeSelectNotAll: false,
                    parentId: null,
                    visible: true,
                    searched: false
                }
                if (!item.hasOwnProperty('children') || item.children.length === 0) {
                    await this.loadingChild(parent)
                }
                parent.open = true

                parent.children.splice(0, 0, Object.assign({}, { dynamicAdd: true, loaded: true }, node))

//                this.generateKey(parent.children, parent.key) // regenerate key
                return Promise.resolve(parent.children)

            },
            async saveNode (item, e) {
                if (!e.target.value) {
                    return
                }
                try {
                    // todo sent data to sever
                    delete item.dynamicAdd // 删除属性

                    Vue.set(item, 'label', e.target.value)

                    e.target.value = ''

                    return Promise.resolve(item) // server return data with id
                } catch (e) {
                    return Promise.reject(e)
                }



            },
            /**
             * 叶子结点 的 icon class
             * @param node
             * @returns {*}
             */
            leafIcon (node) {
                // filter type and return icon class

                if (node.type === 1 || node.type === 2) {
                    return ''
                }
                return 'icon-square'
            }

        },
        components: {Tree}
    }

    export default NodesTree

</script>
<style src="../../node_modules/jquery.fancytree/dist/skin-win8/ui.fancytree.min.css"></style>
<style>
    .tree {
        font-size: 12px;
    }
    .fancytree-container {
        height: 480px;
        width: 100%;
        overflow: auto;
    }
</style>