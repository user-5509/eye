<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div is="EyeNavbar"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="content">2</div>
        </div>
    </div>
</template>

<script>
    import EyeNavbar from './EyeNavbar.vue';
    export default {
      name: 'AppLayout',
        data () {
            return {
            }
        },
        components: {
            'EyeNavbar': EyeNavbar
        }
    }
</script>