<!DOCTYPE html>
<html>
<head>
    <title>Calendrier Test KOGNITIF-Lyes</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    
</head>
<body>
  
<div class="container">
    <br />
    <br />
    <div id="calendar"></div>
</div>

<script>
    $(document).ready(
        function () {
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }   
            });

                var calendar = $('#calendar').fullCalendar({
                    editable:true,
                    header:{
                        left:'prev,next today',
                        center:'title',
                        right:'month,agendaWeek,agendaDay'
                    },
                    //lyes.belkhous89@gmail.com
                    //e49r52mv2pqpiugsgas60rdjmc@group.calendar.google.com
                    //https://calendar.google.com/calendar/embed?src=e49r52mv2pqpiugsgas60rdjmc%40group.calendar.google.com&ctz=Europe%2FParis
                    googleCalendarApiKey: 'AIzaSyCJUcGKup5FrL5zehoEeEz-IKbO57UrGIk',
                    eventSources: [ {googleCalendarId: 'lyes.belkhous89@gmail.com'}],
                    events:'/full-calender',
                    selectable:true,
                    selectHelper: true,
                    select:function(start, end, allDay)
                    {
                        var title = prompt('Entrez un titre à l\'évenement et cliquez sur ok');

                            if(title)
                            {
                                var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
                                var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

                                $.ajax({
                                    url:"/full-calender/action",
                                    type:"POST",
                                    data:{
                                        title: title,
                                        start: start,
                                        end: end,
                                        type: 'add'
                                    },
                                    success:function(data){
                                        calendar.fullCalendar('refetchEvents');
                                        alert("L\'evenement est creé avec succès cliquez sur ok pour finir");
                                    }
                                })
                            }
                    },
        
                    editable:true,
                    eventResize: function(event, delta)
                    {
                        var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                        var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                        var title = event.title;
                        var id = event.id;
                        $.ajax({
                            url:"/full-calender/action",
                            type:"POST",
                            data:{
                                title: title,
                                start: start,
                                end: end,
                                id: id,
                                type: 'update'
                            },
                            success:function(response) {
                                calendar.fullCalendar('refetchEvents');
                                alert("Événement mis à jour avec succès cliquez sur ok pour finir");
                            }
                        })
                    },
                    eventDrop: function(event, delta){
                        var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                        var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                        var title = event.title;
                        var id = event.id;
                        $.ajax({
                            url:"/full-calender/action",
                            type:"POST",
                            data:{
                                title: title,
                                start: start,
                                end: end,
                                id: id,
                                type: 'update'
                            },
                            success:function(response){
                                calendar.fullCalendar('refetchEvents');
                                alert("Événement mis à jour avec succès cliquez sur ok pour finir");
                            }
                        })
                    },

                    eventClick:function(event){
                        if(confirm("Êtes-vous sûr de vouloir supprimer cet evènement ? cliquez sur ok si oui"))
                        {
                            var id = event.id;
                            $.ajax({
                                url:"/full-calender/action",
                                type:"POST",
                                data:{
                                    id:id,
                                    type:"delete"
                                },
                                success:function(response){
                                calendar.fullCalendar('refetchEvents');
                                alert("Événement supprimé avec succès cliquez sur ok pour finir");
                                }
                            })
                        }
                    }
                });
        }
    );
  
</script>
  

</body>
</html>