<div class="navbar">
    <a href="index.php" class="icon-holder">
        <img src="./Bangladesh.png" alt="Product logo">
        <p>BD Crop</p>
    </a>

    <form action="./search.php" method="POST" id="navbar_form"> 
        <select name="selection_type" id="selectElement">
            <option value="district">District</option>
            <option value="crop name">Crop Name</option>
        </select>
        <input type="text" id="search_field" name="search_text" placeholder="Search district">
        <button type="submit" name="submission">Submit</button>
    </form>
</div>

<script>
    selectElement.addEventListener('change', function() {
        search_field.placeholder="Search "+this.value;
    });
</script>

