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
      <button type="button" @click="submitTask()" class="btn btn-primary">Submit</button>
      <button type="button" class="btn btn-danger">Cancel</button>
  </div>
    </div>
</template>
<script>
export default {
   props: ['taskObject'],
   data() {
       return {
            task : {
                title: '',
                description: '',
                date: '',
                status: "pending"
            }
       }
   },
   methods: {
       submitTask: function() {
           this.$emit('task-done',this.task);
       }
   }
}
</script>
