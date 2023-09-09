# maven-central-api-php

PHP client for the maven central REST API

```
<?php

require_once dirname(__FILE__).'/vendor/autoload.php';

use \com\augmentedlogic\mavencentralapi\MavenCentralClient;
use \com\augmentedlogic\mavencentralapi\Result;

$mcc = new MavenCentralClient();

$results = $mcc->searchByGroupId("com.augmentedlogic.simpleslack");
 foreach($results as $r) {
     print "-- doc --\n";
     print $r->getTimestamp()."\n";
     print $r->getVersion()."\n";
     print $r->getArtifactId()."\n";
     print $r->getWebLink()."\n";
 }

sleep(1);

$results = $mcc->search("log");
 foreach($results as $a) {
     print "-- doc --\n";
     print $r->getTimestamp()."\n";
     print $r->getLatestVersion()."\n";
     print $r->getArtifactId()."\n";
     print $r->getWebLink()."\n";
 }

sleep(1);

$results = $mcc->searchByArtifact("guice");
 foreach($results as $r) {
     print "-- doc --\n";
     print $r->getTimestamp()."\n";
     print $r->getLatestVersion()."\n";
     print $r->getArtifactId()."\n";
     print $r->getWebLink()."\n";
 }


```

