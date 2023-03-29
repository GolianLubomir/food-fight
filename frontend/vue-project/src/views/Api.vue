<template>
    <div>
      <div class="control-panel p-5">
          <button @click="downloadData" class="btn btn-info m-2 control-panel-btn text-white">
              Stiahni
          </button>
          <button @click="parseData" class="btn btn-success m-2 control-panel-btn">
              Rozparsuj
          </button>
          <button @click="deleteData" class="btn btn-danger m-2 control-panel-btn">
              Vymaž
          </button>

         
      </div>
      <p class="text-center"> {{response_message}} </p>
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
    downloadData() {
      axiosClient.get('/api/restaurants/download')
        .then(response => {
          console.log(response.data);
          //this.response_message = response.data;
          this.response_message = "Data was downloaded successfully.";
          // Do something with the data
        })
        .catch(error => {
          console.log(error);
        });
    },
    parseData() {
      axiosClient.get('/api/restaurants/parse')
        .then(response => {
          console.log(response.data);
          //this.response_message = response.data;
          this.response_message = "Data was parsed successfully.";
          // Do something with the data
        })
        .catch(error => {
          console.log(error);
        });
    },
    deleteData() {
      axiosClient.delete('/api/meals')
        .then(response => {
          console.log(response.data);
          //this.response_message = response.data;
          this.response_message = "Data was deleted successfully.";
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