
    <fieldset>
        <legend>Search</legend>
        <label></label>		
        <input name="search" type="search" placeholder="Search..." style="width:220px" />
        <input name="searchP" value="search" type="hidden" />
		By:
        <select name="searchSRT1">
            <option value="id">ID</option>
            <option value="corp">Company Name</option>
			<option value="incorp_dt">Inc Date</option>
			<option value="email">Email</option>
			<option value="zipcode">Zip Code</option>
			<option value="owner">Owner</option>
			<option value="phone">Phone</option>
        </select>
         
		<input class="btn btn-primary" style="margin-left:20px" type="submit" value="Submit" />		
		<input class="btn btn-warning"  type="reset" value="Reset" />		
    </fieldset>            
</form>