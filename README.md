## PHP Coding Challenge Solution

Edjay Lindayao Solution for this coding challenge

---

## Overview

The script processes a fixed-width log file (`sample-log.txt`) to extract five fields per line:

- **ID** (12 chars)
- **UserID** (6 chars)
- **BytesTX** (8 chars)
- **BytesRX** (8 chars)
- **DateTime** (17 chars)

It formats and outputs:

1. Pipe-separated logs
2. A correctly sorted list of IDs
3. A sorted, **unique** list of UserIDs with indexing.

Everything is modularized in `utils.php` for clarity and reuse.

---

## Flow in `solution.php`

1. **Load Helpers**

   ```php
   require_once 'utils.php';
   ```

   This makes utility functions available.

2. **Read Input File**

   ```php
   $lines = readLines($inputFile);
   ```

   Uses `readLines()` to load all non-empty lines into an array.

3. **Extract & Format Data**
   For each line:

   - `extractData()` parses fixed-width segments into an associative array.
   - `formatLog()` transforms raw data into the final output string, formatting bytes with commas and date into human-readable form.

4. **Sort & Aggregate**

   - IDs are stored and later sorted naturally using `natsort()`.
   - UserIDs are collected, deduplicated with `array_unique()`, then sorted alphabetically.

5. **Write Output File**
   `writeOutput()` writes three sections into `output.txt`:

   - Formatted logs
   - Sorted IDs
   - Indexed, unique UserIDs

---

## Breakdown of Utility Functions (`utils.php`)

#### `readLines($filePath)`

- Reads all lines ignoring blanks.
- Returns a clean array of strings.

#### `extractData($line)`

- Maps fixed positions into fields:

  - `substr()` selects each field slice.
  - `trim()` removes whitespace.
  - Byte values are cast to integers.
  - Returns a structured array for processing.

#### `formatDateTime($dateTime)`

- Converts raw date (e.g. `2025-03-04 00:00`) into:
  `Tue, 04 March 2025 00:00:00`
- Uses PHP's `strtotime()` and `date()`.

#### `formatLog($data)`

- Formats final log line:

  ```
  UserID|BytesTX|BytesRX|FormattedDate|ID
  ```

- Ensures bytes include commas.

#### `writeOutput($filePath, $logs, $ids, $userIDs)`

1. Writes all formatted logs.
2. Sorts IDs using `natsort()` to ensure “100A” comes before “1000”.
3. Deduplicates and sorts UserIDs, then adds numeric index `[1]`, `[2]`, etc.
4. Appends everything to `output.txt`.

---

### How to Run

Make sure PHP is installed. Then in your terminal:

```bash
php solution.php
```

Ensure that `sample-log.txt`, `solution.php`, and `utils.php` are in the same directory.

---

### Output

```
GITB|660,428|424,450|Tue, 10 September 2019 06:05:00|58QV-Q26X
LBCA|476,255|413,615|Tue, 10 September 2019 06:09:00|278NV-Y69K
CHAI|955,937|669,285|Tue, 10 September 2019 06:15:00|665PP-G26P
...

1AM-H86S
1BR-O31E
1DW-V82Q
...

[1] AALP
[2] ABCM
[3] ABRB
...
```
