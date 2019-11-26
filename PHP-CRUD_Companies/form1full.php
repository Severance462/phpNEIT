<form action="#" method="POST">
    <fieldset>
        <legend>Sort By</legend>

        <label></label>  
        <select name="column">
			<option value="none">None</option>
            <option value="id">ID</option>			
            <option value="corp">Company Name</option>
			<option value="incorp_dt">Inc Date</option>
			<option value="email">Email</option>
			<option value="zipcode">Zip Code</option>
			<option value="owner">Owner</option>
			<option value="phone">Phone</option>
        </select>
		<input type="radio" name="sortDir" value="ASC">Asc 
		<input type="radio" name="sortDir" value="DESC">Desc
		<input type="hidden" name="action" value="sort" />     
    </fieldset>    

