<template>
  <div id="EyeNavbar">
            <nav class="navbar navbar-expand-lg navbar-light alert-secondary h5">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#"><span class="h3">&nesear;</span> <b>КРОСС</b><sup><small>&copy;</small></sup></a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav" id="navbar">
                            <li class="nav-item active" id="menuNodes">
                            <a class="nav-link" href="#">Структура</a>
                        </li>
                        <li class="nav-item" id="menuLines">
                            <a class="nav-link" href="#">Тракты</a>
                        </li>
                    </ul>
                </div>
            </nav>
  </div>
</template>

<script>
import $ from 'jquery';

export default {
  name: 'EyeNavbar',
  data () {
    return {
    }
  }
}
</script>