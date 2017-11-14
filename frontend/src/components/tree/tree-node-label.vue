<template>
    <span>
        <span v-if=" node.hasInterfaces ">
            {{ node[options.labelKey] }} ints!!!
        </span>
        <span v-else>
            {{ node[options.labelKey] }}
        </span>
    </span>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'

    export default {
        name: 'treeNodeLabel',
        props: {
            node: Object,
            options: [Object]
        },
        data() {
            return {
                nodeData: []
            }
        },
        mounted() {
            this.loadInterfaces();
        },
        methods: {
            loadInterfaces: function() {
                if (this.node.hasInterfaces) {
                    axios.get('http://localhost/node/getNodeInterfaces',
                        {
                            params: {
                                nodeId: this.node.id
                            },
                            responseType: 'json'
                        }).then((response) => console.log(response.data));
                }
            }
        }
    }
</script>

<style lang="scss" >
    @import './assets/iconfont/iconfont.css';

    .halo-tree {
        font-size: 14px;
        min-height: 20px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .halo-tree li:hover {
        cursor: pointer;
    }

    .halo-tree .node-selected {
        background-color: #ddd
    }

    .halo-tree li {
        line-height: 20px;
        margin: 0;
        padding: 4px 0 4px 4px;
        position: relative;
        list-style: none;
        user-select: none;
    }

    .halo-tree li > span,
    .halo-tree li > i,
    .halo-tree li > a {
        line-height: 20px;
        vertical-align: middle;
    }

    .halo-tree ul ul li:hover {
        background: rgba(0, 0, 0, .035)
    }

    .halo-tree li:after,
    .halo-tree li:before {
        content: '';
        left: -11px;
        position: absolute;
        right: auto;
        border-width: 1px
    }

    .halo-tree li:before {
        border-left: 1px dashed #999;
        bottom: 50px;
        height: 100%;
        top: -10px;
        width: 1px;

    }

    .halo-tree li:after {
        border-top: 1px dashed #999;
        height: 20px;
        top: 15px;
        width: 12px
    }
    .halo-tree .item-handle-area { height: 24px; }
    .halo-tree li .add-input {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: #fff;
        background-image: none;
        border-radius: 4px;
        border: 1px solid #bfcbd9;
        box-sizing: border-box;
        color: #1f2d3d;
        display: inline-block;
        font-size: inherit;
        height: 24px;
        outline: none;
        padding: 3px 10px;
        transition: border-color .2s cubic-bezier(.645,.045,.355,1);
        width: 100%;
    }

    /* loading */
    .halo-tree li span.halo-tree-iconEle {
        margin: 0;
        width: 24px;
        height: 24px;
        line-height: 20px;
        display: inline-block;
        vertical-align: middle;
        border: 0 none;
        cursor: pointer;
        outline: none;
        text-align: center;
    }

    .halo-tree li span.halo-tree-icon_loading::after {
        display: inline-block;
        font-family: 'iconfont';
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        content: "\e63d";
        -webkit-animation: loadingCircle 1s infinite linear;
        animation: loadingCircle 1s infinite linear;

    }

    @keyframes loadingCircle {
        0% {
            transform-origin: 50% 50%;
            transform: rotate(0deg);
        }
        100% {
            transform-origin: 50% 50%;
            transform: rotate(360deg);
        }
    }

    .halo-tree li span {
        display: inline-block;
        padding: 3px 0;
        text-decoration: none;
        border-radius: 3px;
    }

    .halo-tree li:last-child::before {
        height: 26px
    }

    .halo-tree > ul {
        padding-left: 0
    }

    .halo-tree ul ul {
        padding-left: 19px;
        padding-top: 10px;
    }

    .halo-tree .check {
        display: inline-block;
        position: relative;
        top: -1px;
    }

    .halo-tree .handle-icon {
        margin-right: 0;
    }
    .halo-tree .add-icon {
        position: absolute;
        top: 8px;
        right: 0;
    }

    /*.check.notAllNodes{
      -webkit-appearance: none;
      -moz-appearance: none;
      -ms-appearance: none;
      width: 13px;
    }*/
    .halo-tree  .inputCheck {
        display: inline-block;
        position: relative;
    }

    .halo-tree .inputCheck.notAllNodes {
        font-family: "iconfont" !important;
        font-size: 14px;
        font-style: normal;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .halo-tree .inputCheck.notAllNodes:before {
        content: "\e640";
        display: inline-block;
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 10;
        top: -1px;
        left: 7px;
        transform: translate3d(-30%, -5%, 0);
        /*background-image: url("/../../assets/half.png");*/
    }
</style>
