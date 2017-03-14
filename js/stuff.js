function showEmail(){
	$('#contact').text('maximetinu@gmail.com');
}

function getRankingAjax()
{
   $.ajax({

     type: "GET",
     url: 'php/ranking-ajax.php',
     success: function(data) {
          $('#table').html(data);
     }

   });
}

function getBRankingAjax()
{
   // $.ajax({

   //   type: "GET",
   //   url: 'php/branking-ajax.php',
   //   success: function(data) {
   //        $('#table-b').html(data);
   //   }

   // });
}

// document.addEventListener('visibilitychange', function(){
//     if (!document.hidden)
//         getRankingAjax();
// }
// })