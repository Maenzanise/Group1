$(function(){
    $('.group-toggle').on("click", function(e){
        e.preventDefault();
        
        var id = $(this).data("id");
        var params = {src:"ajax",id:id};
        
        $.post('ajax.php', params, function(e){
            var data = JSON.parse(e);
            
            if(data.success === true){
                var studata = data.data;
                var noOfStu = studata.length;
                
                
                $("#students").html("");
                for(var i = 0; i < noOfStu; i++){
                    console.log(studata[i].name);
                    
                    $("#students").append("<li>" + studata[i].name +"</li>");
                }
                
                
            }else{
                console.log(data);
                $("#students").html("<li>No Students in group.</li>");
            }
        });
    });
});