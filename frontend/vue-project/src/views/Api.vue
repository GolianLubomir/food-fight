<template>
    <div>
      <div class="control-panel p-5">
          <button @click="downloadData" class="btn btn-info m-2 control-panel-btn text-white">
              Stiahni
          </button>
          <button @click="parseData" class="btn btn-success m-2 control-panel-btn">
              Rozparsuj
          </button>

          <div class="my-4">
            

            <div>
              <select id="my-select" v-model="selected_option">
                <option value="0" selected >All</option>
                <option value="1">Karloveská klubovňa</option>
                <option value="2">Eat & Meet</option>
                <option value="3">Venza</option>
              </select>
            </div>
            <button @click="deleteData" class="btn btn-danger my-2 control-panel-btn w-100">
                Vymaž
            </button>
         </div>
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
            response_message: '',
            selected_option: 0
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
      let url = '/api/restaurants';
      if (this.selected_option !== 0) {
        url += `/${this.selected_option}`;
      }
      console.log(url);
      axiosClient.delete(url)
        .then(response => {
          console.log(response.data);
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


label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: bold;
}

select {
  display: block;
  width: 100%;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

select:focus {
  outline: none;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
  border-color: #80bdff;
}
</style>