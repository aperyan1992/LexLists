<!DOCTYPE html>
<html>
<head>
    <title>Minimum Setup</title>
</head>
<body>
<div class="page-header">

    <div class="pull-right form-inline">
        <div class="btn-group">
            <button class="btn btn-primary" data-calendar-nav="prev">&lt;&lt; Prev</button>
            <button class="btn" data-calendar-nav="today">Today</button>
            <button class="btn btn-primary" data-calendar-nav="next">Next &gt;&gt;</button>
        </div>
        <div class="btn-group">
            <button class="btn btn-warning" data-calendar-view="year">Year</button>
            <button class="btn btn-warning active" data-calendar-view="month">Month</button>
            <button class="btn btn-warning" data-calendar-view="week">Week</button>
            <button class="btn btn-warning" data-calendar-view="day">Day</button>
        </div>
    </div>

    <h3>January 2015</h3>
</div>

<div id="calendar" ></div>

<script type="text/javascript">
    var calendar = $("#calendar").calendar({
        events_source: '/dashboard/calendarDates',
        tmpl_path: "/js/calendar/tmpls/",
        view: 'month',
        tmpl_cache: false,
        day: '2015-01-27',
        onAfterEventsLoad: function(events) {
            if(!events) {
                return;
            }
            var list = $('#eventlist');
            list.html('');

            $.each(events, function(key, val) {
                $(document.createElement('li'))
                    .html('<a href="' + val.url + '">' + val.title + '</a>')
                    .appendTo(list);
            });
        },
        onAfterViewLoad: function(view) {
            $('.page-header h3').text(this.getTitle());
            $('.btn-group button').removeClass('active');
            $('button[data-calendar-view="' + view + '"]').addClass('active');
        },
        classes: {
            months: {
                general: 'label'
            }
        }
    });
    (function($) {

        $('.btn-group button[data-calendar-nav]').each(function() {
            var $this = $(this);
            $this.click(function() {
                calendar.navigate($this.data('calendar-nav'));
            });
        });

        $('.btn-group button[data-calendar-view]').each(function() {
            var $this = $(this);
            $this.click(function() {
                calendar.view($this.data('calendar-view'));
            });
        });

        $('#first_day').change(function(){
            var value = $(this).val();
            value = value.length ? parseInt(value) : null;
            calendar.setOptions({first_day: value});
            calendar.view();
        });

        $('#language').change(function(){
            calendar.setLanguage($(this).val());
            calendar.view();
        });

        $('#events-in-modal').change(function(){
            var val = $(this).is(':checked') ? $(this).val() : null;
            calendar.setOptions({modal: val});
        });
        $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
            //e.preventDefault();
            //e.stopPropagation();
        });
    }(jQuery));
</script>
</body>
</html>