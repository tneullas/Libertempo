<?php
defined('_PHP_CONGES') or die('Restricted access');
$querys = \includes\SQL::getQuerys();
$total  = 0;
?>
</div>
</div>
<footer>
<div id="bottom">
<?=BOTTOM_TEXT;?>
</div>
<?php if (SHOW_SQL): ?>
    <div id="show-sql">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Time</th>
                    <th>Total</th>
                    <th>Results</th>
                    <th>File</th>
                    <th>Line</th>
                    <th>Query</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($querys as $num => $v):
                    $time = $v['t2'] - $v['t1'];
                    $total += $time;
                ?>
                <tr>
                    <td><?=$num?></td>
                    <td><?=$time?></td>
                    <td><?=$total?></td>
                    <td><?=$v['results']?></td>
                    <td><?=$v['back']['file']?></td>
                    <td><?=$v['back']['line']?></td>
                    <td><?=$v['query']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
<?php endif;?>
</footer>
</section>
</section>
</section>
<script>
var usersCN = [];
var usersUID = [];
$( "#autocomplete" ).autocomplete({
    source: "/Libertempo/admin/admin_user_autocomplete.php",
    minLength: 3,
    select: function(event,ui){
        usersUID.push(ui.item.uid);
        $('#autocomplete-list').append('<span class="uid-flag" data-uid="'+ui.item.uid+'">'+ui.item.cn+'<span class="delete">&times;</span></span>');
        $("#autocomplete-uid").val(usersUID.join(','));
        $(this).val('');
        return false;
    }
}).autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $( "<li>" )
        .append( "<div>"+ item.cn +"<br /><i>"+ item.mail +"</i></div>" )
        .appendTo( ul );
};
$(document).on('click', '.uid-flag > .delete', function(e) {
    e.preventDefault();
    var parent = $(this).parent();
    var index = usersUID.indexOf(parent.data('uid'));
    if (index > -1) {
        usersUID.splice(index, 1);
    }
    $("#autocomplete-uid").val(usersUID.join(','));
    parent.remove();
})
</script>
</body>
</html>
