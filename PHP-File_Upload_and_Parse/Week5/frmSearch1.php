<form action="#" method="POST">
    <fieldset>
        <legend>Sort By</legend>

        <label></label>  
        <select name="column">
			<option value="none">None</option>
            <option value="id">ID</option>			
            <option value="name">School Name</option>
			<option value="city">City</option>
			<option value="state">State</option>
        </select>
		<input type="radio" checked="checked" name="sortDir" value="ASC">Asc 
		<input type="radio" name="sortDir" value="DESC">Desc
		<input type="hidden" name="action" value="sort" />     
    </fieldset>    

