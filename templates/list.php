<!DOCTYPE html>
<html>
    <head>
        <title>Quotes - New Quote</title>
        <style>
            body {width:auto; margin:0 30% 0 2em; font-size:16px}
            h1 {font-size:1.2em; font-weight: normal; color:#666}
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
    <section>
        <? foreach($quotes as $quote)
        {
        ?>
            <article>
                <p><? echo($quote->quote)?></p>
                <p><? echo($quote->author)?>, <? echo($quote->source) ?></p>
            </article>
        <?    
        }
        ?>
    </section>
</body>