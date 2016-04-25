<?php

// It may take a whils to crawl a site ...
set_time_limit(10000);

// Inculde the phpcrawl-mainclass
include("libs/PHPCrawler.class.php");

// Extend the class and override the handleDocumentInfo()-method 
class MyCrawler extends PHPCrawler 
{
  function handleDocumentInfo($DocInfo) 
  {
    // Just detect linebreak for output ("\n" in CLI-mode, otherwise "<br>").
    if (PHP_SAPI == "cli") $lb = "\n";
    else $lb = "<br />";

    // Print the URL and the HTTP-status-Code
    echo "Page requested: ".$DocInfo->url." (".$DocInfo->http_status_code.")".$lb;
    
    // Print the refering URL
    echo "Referer-page: ".$DocInfo->referer_url.$lb;
    
    // Print if the content of the document was be recieved or not
    if ($DocInfo->received == true)
      echo "Content received: ".$DocInfo->bytes_received." bytes".$lb;
    else
      echo "Content not received".$lb; 
    
    // Now you should do something with the content of the actual
    // received page or file ($DocInfo->source), we skip it in this example 
    
    echo $lb;
    
    flush();
  } 
}

// Now, create a instance of your class, define the behaviour
// of the crawler (see class-reference for more options and details)
// and start the crawling-process.

$crawler = new MyCrawler();

// URL to crawl
$crawler->setURL("http://m2.magento.loc/");

// Only receive content of files with content-type "text/html"
$crawler->addContentTypeReceiveRule("#text/html#");

// Ignore links to pictures, dont even request pictures
$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");
$crawler->addURLFilterRule("#customer# i");
$crawler->addURLFilterRule("#checkout# i");
$crawler->addURLFilterRule("#search# i");
$crawler->addURLFilterRule("#color=# i");
$crawler->addURLFilterRule("#material=# i");
$crawler->addURLFilterRule("#price=# i");
$crawler->addURLFilterRUle("#pattern=# i");
$crawler->addURLFilterRUle("#climate=# i");
$crawler->addURLFilterRUle("#style_general=# i");
$crawler->addURLFilterRUle("#size=# i");
$crawler->addURLFilterRUle("#cat=# i");
$crawler->addURLFilterRUle("#media# i");
$crawler->addURLFilterRUle("#static# i");
$crawler->addURLFilterRUle("#style_bottom=# i");
$crawler->addURLFilterRUle("#activity=# i");
$crawler->addURLFilterRUle("#features_bags=# i");
$crawler->addURLFilterRUle("#strap_bags=# i");
$crawler->addURLFilterRUle("#style_bags=# i");
$crawler->addURLFilterRUle("#sendfriend# i");
$crawler->addURLFilterRUle("#review# i");
$crawler->addURLFilterRUle("#category_gear=# i");
$crawler->addURLFilterRUle("#gender=# i");



// Store and send cookie-data like a browser does
$crawler->enableCookieHandling(true);

// Set the traffic-limit to 1 MB (in bytes,
// for testing we dont want to "suck" the whole site)
$crawler->setTrafficLimit(1000000 * 1024);

// Thats enough, now here we go
$crawler->go();

// At the end, after the process is finished, we print a short
// report (see method getProcessReport() for more information)
$report = $crawler->getProcessReport();

if (PHP_SAPI == "cli") $lb = "\n";
else $lb = "<br />";
    
echo "Summary:".$lb;
echo "Links followed: ".$report->links_followed.$lb;
echo "Documents received: ".$report->files_received.$lb;
echo "Bytes received: ".$report->bytes_received." bytes".$lb;
echo "Process runtime: ".$report->process_runtime." sec".$lb; 
?>
