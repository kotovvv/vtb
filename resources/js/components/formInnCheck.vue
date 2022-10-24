<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Проверка ИНН в ВТБ</div>
          <div class="card-body">
            <label for="inn" class="hidden-visually">ИНН: </label>
            <input type="number" name="inn" @change="newInn" id="inn" v-model="inn" />
            <button type="button" class="saccess" @click="checkInn">Проверить</button>
            <div>{{ message }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "InnCheck",
  mounted() {

  },
  data: () => ({
    inn: "",
    message: "",
  }),
  methods: {
    newInn() {
      this.message = "";
    },
    checkInn() {
      const self = this;
      axios
        .get("api/CheckInn/" + self.inn)
        .then((res) => {
          console.log(res.data.message);
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>
