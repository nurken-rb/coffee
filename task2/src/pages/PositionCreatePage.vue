<script>
import {defineComponent, ref} from "vue";
import axios from "axios";
import {comment} from "postcss";
import * as json from "postcss";

export default defineComponent({
  name: 'IndexPage',
  setup () {
    const position = ref( {
      date: '',
      sum: 0,
      comment: ''
    });
    const response_msg = ref('');

    function submit() {
      axios.post('http://localhost:8000/api/position/create', JSON.stringify(position.value))
        .then(response => {
          if (response.data.success) {
            response_msg.value = response.data.notification.title
          }
          console.log(response.data)
        })
    }

    return {
      position,
      response_msg,
      submit
    }
  }
});

</script>

<template>
  <div class="container">
    <h4>Добавить</h4>
    <form class="form" @submit="submit">
      <span>Сумма</span>
      <input type="int" v-model="position.sum" required>
      <span>Комментарий</span>
      <input type="text" v-model="position.comment">
      <button type="submit" class="btn q-btn">Сохранить</button>
    </form>

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

.response {
  height: 30px;
  margin-top: 50px;
  background: #b3efc2;
}

</style>
