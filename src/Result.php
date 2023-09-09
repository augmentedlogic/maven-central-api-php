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


class Result
{

    private $doc = null;

    function __construct($doc)
    {
       $this->doc = $doc;
    }

    public function getTimestamp(): int
    {
      return ($this->doc->timestamp / 1000);
    }

    public function getVersion(): ?string
    {
      return $this->doc->v ?: null;
    }

    public function getLatestVersion(): ?string
    {
      return $this->doc->latestVersion ?: null;
    }

    public function getGroupId(): string
    {
      return $this->doc->g;
    }

    public function getArtifactId(): string
    {
      return $this->doc->a;
    }

    public function getWebLink(): string
    {
      return "https://central.sonatype.com/artifact/".$this->doc->g."/".$this->doc->a;
    }

    public function getAsObject(): object
    {
      return $this->doc;
    }

    public function getTags(): array
    {
      return $this->doc->tags;
    }


}
