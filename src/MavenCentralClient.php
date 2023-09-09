<?php
/**
  Copyright (c) 2023 Wolfgang Hauptfleisch/augmentedlogic <dev@augmentedlogic.com>

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.
 **/
namespace com\augmentedlogic\mavencentralapi;


class MavenCentralClient
{

   private $result = null;
   private $user_agent = "php-maven-client";
   private $timeout = 20;
   private $connect_timeout = 20;
   private $rows = 20;
   private $http_status = 0;

   private function get($url): object
   {
    $this->http_status = 0;
    $ch = curl_init($url);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
    curl_setopt( $ch, CURLOPT_USERAGENT, $this->user_agent);
    $result = curl_exec($ch);
    $this->http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return json_decode($result);
   }

   public function getHttpStatus(): int
   {
      return $this->http_status;
   }

   public function setResultRows(int $rows): int
   {
      return $this->rows = $rows;
   }

   public function setUserAgent(string $user_agent): void
   {
      $this->user_agent = $user_agent;
   }

   public function setTimeout(string $timeout): void
   {
      $this->timeout = $timeout;
   }

   public function setConnectTimeout(int $connect_timeout): void
   {
      $this->connect_timeout = $connect_timeout;
   }

   /**
    * From the sonatype documentation:
    * Search for all artifacts in the groupId "com.google.inject."
    * For each artifact, returns details for the most recent version released.
    **/
   public function searchByGroupId(string $s): array
   {
     $url = "https://search.maven.org/solrsearch/select?q=g:".$s."&core=gav&rows=".$this->rows."&wt=json";
     $a = array();
     $results = $this->get($url);
     foreach($results->response->docs as $doc) {
        $a[] = new Result($doc);
     }
     return $a;
   }

   /**
    * From the sonatype documentation:
    * Mimics typing "guice" in the basic search box. Returns first page of artifacts with "guice" in the groupId or artifactId
    * and lists details for most recent version released.
    **/
   public function search(string $s): array
   {
     $url = "https://search.maven.org/solrsearch/select?q=".$s."&rows=".$this->rows."&wt=json";
     print "{$url}\n";
     $a = array();
     $results = $this->get($url);
     foreach($results->response->docs as $doc) {
        $a[] = new Result($doc);
     }
     return $a;
   }

   /**
    * From the sonatype documentation:
    * Search for any artifactId named "guice," irrespective of groupId.
    * For each artifact returns details for the most recent version released.
    **/
   public function searchByArtifact(string $s): array
   {
     $url = "https://search.maven.org/solrsearch/select?q=a:".$s."&rows=".$this->rows."&wt=json";
     $a = array();
     $results = $this->get($url);
     foreach($results->response->docs as $doc) {
        $a[] = new Result($doc);
     }
     return $a;
   }


}

