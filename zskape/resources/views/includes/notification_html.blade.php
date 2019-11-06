
<script type="text/javascript">


var notification_html = [];

notification_html[0] = "<div class='activity-item'> <i class='fa fa-tasks text-warning'></i> <div class='activity'></div>{{ session('flash_message')[1] }}<br /> Don't have an account? <a href='register'>Sign up</a> to register an new account</div></div>",
notification_html[1] = '<div class="activity-item"> <i class="fa fa-check text-success"></i> <div class="activity">{{ session('flash_message')[1] }}</div> </div>',
notification_html[2] = '<div class="activity-item"> <i class="fa fa-heart text-danger"></i> <div class="activity">{{ session('flash_message')[1] }}</div> </div>',
notification_html[3] = '<div class="activity-item"> <i class="fa fa-shopping-cart text-success"></i> <div class="activity">{{ session('flash_message')[1] }}</div> </div>',
notification_html[4] = '<div class="activity-item"> <i class="fa fa-shopping-cart text-delete"></i> <div class="activity">{{ session('flash_message')[1] }}</div> </div>';


</script>