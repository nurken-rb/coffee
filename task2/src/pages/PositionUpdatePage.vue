<script>
import {defineComponent, ref} from "vue";
import axios from "axios";

export default defineComponent({
  name: 'IndexPage',
  setup () {
    const id = ref(0);
    const position = ref(['']);
    const response_msg = ref('');

    function getPosition(id) {
      axios.get('http://localhost:8000/api/position/' + id)
        .then(response => {
          position.value = response.data[0]
          console.log(position.value)
      })
    }

    function submit() {
      axios.post('http://localhost:8000/api/position/update/' + id.value , JSON.stringify(position.value))
        .then(response => {
          if(response.data.success) {
            response_msg.value = response.data.notification.title
            console.log(response.data)
          }
        })
    }

    function deletePos() {
      axios.get('http://localhost:8000/api/position/delete/' + id.value)
        .then(response => {
          response_msg.value = response.data.notification.title
        })
    }

    return {
      id,
      position,
      getPosition,
      response_msg,
      submit,
      deletePos,
    }
  },
  beforeMount() {
    this.id = this.$route.params.id
    this.getPosition(this.id)
  }
})
</script>

<template>
  <div class="container">
    <h4>{{id}}</h4>
    <form class="form" @submit="submit">
      <span>Дата</span>
      <input type="text" v-model="position.date" required>
      <span>Сумма</span>
      <input type="int" v-model="position.sum" required>
      <span>Комментарий</span>
      <input type="text" v-model="position.comment">
      <button type="submit" class="btn q-btn">Сохранить</button>
    </form>
    <div>
      <button class="btn btn-danger" @click="deletePos">Удалить</button>
    </div>
    <div class="response" v-if="response_msg">
      {{response_msg}}
    </div>
  </div>
</template>

<style scoped>
.form {
  display: flex;
  flex-direction: column;
}

.btn-danger {
  width: 100%;
  height: 40px;
  margin-top: 20px;
  background: #eeb9bf;
  border: none;
  border-radius: 5px;
}

.response {
  height: 30px;
  margin-top: 50px;
  background: #b3efc2;
}
</style>
