function showEmail(){
	$('#contact').text('maximetinu@gmail.com');
}

function getSummary()
{
   $.ajax({

     type: "GET",
     url: 'php/ranking-ajax.php',
     success: function(data) {
          $('#table').html(data);
     }

   });
}