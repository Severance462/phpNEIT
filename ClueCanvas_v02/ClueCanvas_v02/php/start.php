<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

<!-- Modal -->
<div id="startModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Game Start</h4>
            </div>
            <div class="modal-body">
                <form>
                    <p>Please select the number of players: </p>
                    <select id="players" class="btn btn-info btn-block btn-sm" name="players">
                        <option value="0">Players:</option>
                        <option value="1">2</option>
                        <option value="2">3</option>
                        <option value="3">4</option>
                        <option value="4">5</option>
                        <option value="5">6</option>                        
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnStartClose" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<?php 




?>