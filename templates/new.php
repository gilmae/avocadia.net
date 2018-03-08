<!DOCTYPE html>
<html>
    <head>
        <title>Quotes - New Quote</title>
        <style>
            body {width:auto; margin:0 30% 0 2em;}
            h1 {font-size:1em;}
            form {width:auto; }
            fieldset {border:0;}
            form section {
                padding: 1em 2em;;
            }

            form label {
                margin-right:2em;
            }
            form textarea, form input {
                width:60%;
            }

            input[type=submit] {
                width:auto;
            }
        </style>
    </head>
    <body>
    <h1>Quotes</h1>
    <form action="create" method="POST">
        <fieldset> 
            <section><label for="quote">Quote</label><textarea name="quote[quote]" id="quote" rows="10" cols="20" placeholder="What was said...?"></textarea></section>
            <section><label for="author">Author</label><input name="quote[author]" id="author" placeholder="Who said it..." /></section>
            <section><label for="source">Source</label><input name="quote[source]" id="source"  placeholder="WHere did they say it..." /></section>
        </fieldset>
        <input type="submit" value="save" />
    </form>
</body>