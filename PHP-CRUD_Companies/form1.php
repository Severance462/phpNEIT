<form action="#" method="POST">
    <fieldset>
        <legend>Sort By</legend>

        <label></label>  
        <select name="column">
			<option value="none">None</option>
            <option value="id">ID</option>			
            <option value="corp">Company Name</option>
        </select>
		<input type="radio" name="sortDir" value="ASC">Asc 
		<input type="radio" name="sortDir" value="DESC">Desc
		<input type="hidden" name="action" value="sort" />
        <!--<select name="sortDir">
            <option value="ASC">Asc</option>
            <option value="DESC">Desc</option>
			</select>-->
        <!--<input type="hidden" name="action" value="Submit1" />-->
        <!--<input style="margin-left:20px" type="submit" value="Submit" />-->
    </fieldset>    

