$(document).ready(function(){
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $(document).on('click','#btn-more',function(){
        var id = $(this).data('id');
        $("#btn-more").html("<i class='fa fa-spinner' aria-hidden='true'></i>");
        $.ajax({
            url : '/loaddata',
            method : "POST",
            data : {id:id},
            dataType : "text",
            success : function (data)
            {
               if(data != '')
               {
                   $('#remove-row').remove();
                   $('#load-data').append(data);
               }
               else
               {
                   $('#btn-more').html("No Data");
               }
            }
        });
    });
    $(document).on('click','#btn-more-user',function(){
        var id = $(this).data('id');
        $("#btn-more-user").html("<i class='fa fa-spinner' aria-hidden='true'></i>");
        $.ajax({
            url : '/loaddatauser',
            method : "POST",
            data : {id:id},
            dataType : "text",
            success : function (data)
            {
               if(data != '')
               {
                   $('#remove-row').remove();
                   $('#load-data').append(data);
               }
               else
               {
                   $('#btn-more-user').html("No Data");
               }
            }
        });
    });
    $(document).on('click','#btn-more-author',function(){
        var id = $(this).data('id');
        $("#btn-more-author").html("<i class='fa fa-spinner' aria-hidden='true'></i>");
        $.ajax({
            url : '/loaddataauthor',
            method : "POST",
            data : {id:id},
            dataType : "text",
            success : function (data)
            {
               if(data != '')
               {
                   $('#remove-row').remove();
                   $('#load-data').append(data);
               }
               else
               {
                   $('#btn-more-author').html("No Data");
               }
            }
        });
    });
    $(document).on('click','#btn-more-date',function(){
        var id = $(this).data('id');
        $("#btn-more-date").html("<i class='fa fa-spinner' aria-hidden='true'></i>");
        $.ajax({
            url : '/loaddatadate',
            method : "POST",
            data : {id:id},
            dataType : "text",
            success : function (data)
            {
               if(data != '')
               {
                   $('#remove-row').remove();
                   $('#load-data').append(data);
               }
               else
               {
                   $('#btn-more-date').html("No Data");
               }
            }
        });
    });
    $(document).on('click','#btn-more-search',function(){
        var id = $(this).data('id');
        var da =$('#btn-more-search').attr('role');
        $("#btn-more-search").html("<i class='fa fa-spinner' aria-hidden='true'></i>");
        $.ajax({
            url : '/loaddatasearch',
            method : "POST",
            data : {da:da,id:id},
            dataType : "text",
            success : function (data)
            {
               if(data != '')
               {
                   $('#remove-row').remove();
                   $('#load-data').append(data);
               }
               else
               {
                   $('#btn-more-search').html("No Data");
               }
            }
        });
    });


});
