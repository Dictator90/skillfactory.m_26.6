<?php

class Html implements Iterator {

    const ROW_SIZE = 4096;

    protected $filePointer = null;
    protected $currentElement = null;

    protected $rowCounter = null;

    public function __construct($file) {
        try {
            $this->filePointer = fopen($file, 'r+b');
        } catch (\Exception $e) {
            throw new \Exception('The file "' . $file . '" cannot be read.');
        }
    }

    public function rewind(): void {
        $this->rowCounter = 0;
        rewind($this->filePointer);
    }

    public function current() {
        $this->currentElement = fgets($this->filePointer, self::ROW_SIZE);
        $this->rowCounter++;

        return $this->currentElement;
    }

    public function key(): int {
        return $this->rowCounter;
    }

    public function next(): bool{
        if (is_resource($this->filePointer)) {
            return !feof($this->filePointer);
        }

        return false;
    }

    public function valid(): bool {
        if (!$this->next()) {
            if (is_resource($this->filePointer)) {
                fclose($this->filePointer);
            }

            return false;
        }

        return true;
    }
}
