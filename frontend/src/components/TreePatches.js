import Vue from 'vue'
import 'vue-awesome/icons'
import Icon from '../../node_modules/vue-awesome/components/Icon.vue'
import NodesTreeName from './NodesTreeName.vue'

export function treeNodeIcon(iconName, selector) {
    let component = Vue.extend({
        template: '<icon name="' + iconName + '"></icon>',
        components: {Icon}
    })
    return new component().$mount(selector)
}

export function treeNodeName(nodeName, selector) {
    let component = Vue.extend({
        template: '<span is="NodesTreeName" nodeName="' + nodeName + '"></span>',
        components: {NodesTreeName}
    })
    return new component().$mount(selector)
}