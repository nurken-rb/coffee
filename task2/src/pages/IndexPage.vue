<template>
  <div class="container">
    id | date | sum | comment
    <div class="position" v-for="position in positionList">
      <span>{{position.id}} | {{position.date}} | {{position.sum}} | {{position.comment}}</span>
      <router-link :to="{name: 'positionUpdate', params: { id: position.id }}">
        Редактировать
      </router-link>
    </div>
  </div>
</template>

<script>
import {defineComponent, ref} from 'vue'
import axios from "axios";

export default defineComponent({
  name: 'IndexPage',
  setup () {
    const positionList = ref([]);

    function getPositionList() {
      axios.get('http://localhost:8000/api/position/list')
        .then(response => {
          positionList.value = response.data
      })
    }

    return {
      positionList,
      getPositionList,
    }
  },
  beforeMount() {
    this.getPositionList();
  }
})
</script>

<style>
.container {
  width: 75%;
  margin: 10px auto;
}

.position {
  display: flex;
  margin-top: 20px;
  background: #c1efc3;
}

.position span {
  margin-top: 10px;
  margin-left: 10px;
  font-size: 15px;
}

.position a {
  margin-top: 5px;
  margin-left: auto;
}
</style>
