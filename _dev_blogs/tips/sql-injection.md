>
    Laravel will protect you against this type of attack since both the query
    builder and Eloquent use PHP Data Objects (PDO) class behind the scenes. PDO
    uses prepared statements, which allows you to safely pass any parameters without
    having to escape and sanitize them.