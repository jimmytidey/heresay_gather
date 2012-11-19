<? 
/*  This page renders iFrames for every site 
*   If the site has the default scraper (as specified in the db)
*   then it lumps them all together 
*
*/


include ('../header.php'); ?>

<h1>Gather Data From Websites</h1>

<?

$results = $db->get_non_default_sites();

?>

<div class='grid_12 alpha'>
    <h2>All sites with default scraper</h2>
</div>

<div class='grid_12'>
    <p>
        <input type='button'  data-name='default' data-id='default'  class='btn_gather' value='Scan' >

    </p>
    <iframe id='site_default' class='results_iframe' > </iframe>
</div>

<?


foreach($results as $result) { ?>
   
        <div class='grid_12 alpha'>
            <h2><?=$result['site']; ?></h2>
            
        </div>
        
        <div class='grid_12'>
            <p>
                <input type='button'  data-name='<?=$result['site']; ?>' data-id='<?=$result['site_id']; ?>'  class='btn_gather' value='Scan' >

            </p>
            <iframe id='site_<?=$result['site_id']; ?>' class='results_iframe' > </iframe>
        </div>
            
    <? }

include ('../footer.php');

?>