<script>
    fetch('http://localhost:8888/user/1')
        .then(response => response.json())
        .then(data => console.log(data));
</script>