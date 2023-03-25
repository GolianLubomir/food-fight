<template>

    <div class="control-panel">
        <button @click="getData1" class="btn btn-info m-2 control-panel-btn text-white">
            Stiahni
        </button>
        <button @click="getData2" class="btn btn-success m-2 control-panel-btn">
            Rozparsuj
        </button>
        <button  class="btn btn-danger m-2 control-panel-btn">
            Vymaž
        </button>

        <p> {{response}} </p>
    </div>

</template>

<script>
import axiosClient from '../axios';

export default {
    computed:{
        response() {
            return this.response_message
        }
    },
    data(){
        return {
            response_message: ''
        }
    },
  methods: {
    getData1() {
      axiosClient.get('/api/restaurants/download')
        .then(response => {
          console.log(response.data);
          this.response_message = response.data;
          // Do something with the data
        })
        .catch(error => {
          console.log(error);
        });
    },
    getData2() {
      axiosClient.get('/api/restaurants/parse')
        .then(response => {
          console.log(response.data);
          this.response_message = response.data;
          // Do something with the data
        })
        .catch(error => {
          console.log(error);
        });
    },
    getData3() {
      axiosClient.get('/api/data3')
        .then(response => {
          console.log(response.data);
          // Do something with the data
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>

<style>
.control-panel{
    width: fit-content;
    margin: auto;
}

.control-panel-btn{
    width: 125px;
    font-size: 18px;
}
</style>