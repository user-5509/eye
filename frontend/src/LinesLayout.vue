<template>
    <div class="container pt-3">
        <div class="row">
            <div class="col-6">
                <button type="button" id="create-line" class="btn btn-primary">
                    <i class="fa fa-file-o"></i> Создать
                </button>
                <div class="pt-2" id="listContainer">
                    list
                </div>
            </div>
            <div class="col-6" id="lineAbout">
                line about
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      name: 'LinesLayout',
        data () {
            return {
            }
        }
    }
</script>