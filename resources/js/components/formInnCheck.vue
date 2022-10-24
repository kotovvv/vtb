<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Проверка ИНН в ВТБ</div>
          <div class="card-body">
              <label for="inn" class="hidden-visually">ИНН: </label>
              <input type="number" name="inn" id="inn" v-model="inn" />
              <button type="submit" @click="checkInn">Проверить</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'InnCheck',
  mounted() {
    console.log("InnCheck component mounted");
  },
  data:()=>({
    inn:'',
  }),
  methods: {
    checkInn(){
        console.log(this.inn)
    }
  },
};
</script>
