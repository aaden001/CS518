 $(function () {

     $('#creatGroup').on('click', function () {
         $("#dialogDiv").dialog("open");
     });

     $("#dialogDiv").dialog({
         autoOpen: false,
         resizable: false,
         width: 400,
         height: "auto",
         modal: true,
         title: 'Create a new group',
     
     });

 });
