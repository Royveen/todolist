<template>
    <div class="task-form">
   <div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label">Title</label>
    <div class="col-sm-10">
      <input type="text"  v-model = "task.title" class="form-control " id="title" >
    </div>
  </div>

   <div class="form-group row">
    <label for="desc" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-10">
      <input type="text"  v-model = "task.description" class="form-control" id="desc" >
    </div>
  </div>

   <div class="form-group row">
    <label for="dateBox" class="col-sm-2 col-form-label">Date</label>
    <div class="col-sm-10">
      <input type="date" v-model = "task.date" class="form-control" id="dateBox" >
    </div>
  </div>

  <div class="button-box">
      <button type="button" @click="submitTask()" v-if="!taskObject" class="btn btn-primary">Submit</button>
      <button type="button" @click="editTask()" v-if="taskObject" class="btn btn-primary">Edit</button>
      <button type="button" @click="closeTaskForm()" class="btn btn-danger">Cancel</button>
  </div>
    </div>
</template>
<script>
export default {
   props: ['taskObject', 'defaultDate'],
   data() {
       return {
            task : {
                title: '',
                description: '',
                date: this.defaultDate?this.defaultDate:'',
                status: "pending"
            }
       }
   },
   created() {
     if(this.taskObject) {
       this.task.title = this.taskObject.title;
       this.task.description = this.taskObject.description;
       this.task.date = this.formatDate(this.taskObject.date)
     }
   },
   methods: {
       submitTask: function() {
         fetch('api/tasks', {
           method: 'post',
           body: JSON.stringify(this.task),
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
             'content-type': 'application/json'
           }
         }).then(res=>res.json())
         .then(data => {
           this.$emit('task-done',data);
         })
         .catch(err => console.log(err));
       },
       editTask: function() {
         fetch('api/tasks/'+this.taskObject.id, {
           method: 'put',
           body: JSON.stringify(this.task),
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
             'content-type': 'application/json'
           }
         }).then(res=>res.json())
         .then(data => {
           this.$emit('task-edited',data);
         })
         .catch(err => console.log(err));
       },
       formatDate($date) {
                return moment($date).format('YYYY-DD-MM');
            },
       closeTaskForm: function() {
         this.task=null;
         this.$emit('task-done',this.task);
       }
   }
}
</script>
