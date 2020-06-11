<?php
//**************************************************************************************************
    //**********************************************************************************************
    // (2017/05/25) Page 0007 , sql_injecttion_prevention($fn_sw, $s_entity)
    //              Parameter : (integer) $fn_sw : "字串取代"功能切換 ;
    //                          (string) $s_entity : 輸入的字串資訊 ;
    //              Return    : (string) 處理後的字串資訊 ;
    //              Description :  sql_injecttion_prevention($fn_sw, $s_entity) , 處理 sql injecttion 的問題
    //**********************************************************************************************
    function sql_injecttion_prevention($fn_sw, $s_entity) {
        $rc_string = $s_entity;
        //******************************************************************************************
        // --------------------------------------------------------
        // | html  | chr   | acsii | dec   | note                 |      html  : { 4 , 5 , 6 , 7 }
        // --------------------------------------------------------      chr   : { 2 , 3 , 6 , 7 }
        // |   0   |   0   |   0   |   0   |  (x)                 |      acsii : { 1 , 3 , 5 , 7 }
        // |   0   |   0   |   1   |   1   |  acsii               |
        // |   0   |   1   |   0   |   2   |  chr                 |
        // |   0   |   1   |   1   |   3   |  chr , acsii         |
        // |   1   |   0   |   0   |   4   |  html                |
        // |   1   |   0   |   1   |   5   |  html , acsii        |
        // |   1   |   1   |   0   |   6   |  html , chr          |
        // |   1   |   1   |   1   |   7   |  html , chr , acsii  |
        // --------------------------------------------------------
        //******************************************************************************************

        if (($fn_sw === 4)||($fn_sw === 5)||($fn_sw === 6)||($fn_sw === 7)) { $rc_string = html_char_replace($rc_string); }
        if (($fn_sw === 2)||($fn_sw === 3)||($fn_sw === 6)||($fn_sw === 7)) { $rc_string = chr_char_replace($rc_string); }
        if (($fn_sw === 1)||($fn_sw === 3)||($fn_sw === 5)||($fn_sw === 7)) { $rc_string = ascii_char_replace($rc_string); }

        //******************************************************************************************
        return $rc_string;
    }
    //**********************************************************************************************

    //**********************************************************************************************
    // (2017/05/25) Page 0008 , html_char_replace($s_str)
    //              Parameter : (string) $s_str : 輸入的字串資訊 ;
    //              Return    : (string) 取代後的字串資訊 ;
    //              Description :  html_char_replace($s_str) , 取代 html 格式的 "不正常" 字元
    //**********************************************************************************************
    function html_char_replace($s_str) {
        $rc_string = $s_str;  $r_char = 'n';                          // ------------------------------------------------
        //************************************************************// |  binary   | oct | dec | hex | glyh / abbr    |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('%00%', $r_char, $rc_string);        // | 0000 0000 | 000 |   0 |  00 |    NUL (\0)    |
        $rc_string = str_replace('%01%', $r_char, $rc_string);        // | 0000 0001 | 001 |   1 |  01 |    SOH         |
        $rc_string = str_replace('%02%', $r_char, $rc_string);        // | 0000 0010 | 002 |   2 |  02 |    STX         |
        $rc_string = str_replace('%03%', $r_char, $rc_string);        // | 0000 0011 | 003 |   3 |  03 |    ETX         |
        $rc_string = str_replace('%04%', $r_char, $rc_string);        // | 0000 0100 | 004 |   4 |  04 |    EOT         |
        $rc_string = str_replace('%05%', $r_char, $rc_string);        // | 0000 0101 | 005 |   5 |  05 |    ENQ         |
        $rc_string = str_replace('%06%', $r_char, $rc_string);        // | 0000 0110 | 006 |   6 |  06 |    ACK         |
        $rc_string = str_replace('%07%', $r_char, $rc_string);        // | 0000 0111 | 007 |   7 |  07 |    BEL (\a)    |
        $rc_string = str_replace('%08%', $r_char, $rc_string);        // | 0000 1000 | 010 |   8 |  08 |    BS  (\b)    |
        $rc_string = str_replace('%09%', $r_char, $rc_string);        // | 0000 1001 | 011 |   9 |  09 |    HT  (\t)    |
        $rc_string = str_replace('%0A%', $r_char, $rc_string);        // | 0000 1010 | 012 |  10 |  0A |    LF  (\n)    |
        $rc_string = str_replace('%09%', $r_char, $rc_string);        // | 0000 1001 | 011 |   9 |  09 |    HT  (\t)    |
        $rc_string = str_replace('%0A%', $r_char, $rc_string);        // | 0000 1010 | 012 |  10 |  0A |    LF  (\n)    |
        $rc_string = str_replace('%0B%', $r_char, $rc_string);        // | 0000 1011 | 013 |  11 |  0B |    VT  (\v)    |
        $rc_string = str_replace('%0C%', $r_char, $rc_string);        // | 0000 1100 | 014 |  12 |  0C |    FF  (\f)    |
        $rc_string = str_replace('%0D%', $r_char, $rc_string);        // | 0000 1101 | 015 |  13 |  0D |    CR  (\r)    |
        $rc_string = str_replace('%0E%', $r_char, $rc_string);        // | 0000 1110 | 016 |  14 |  0E |    SO          |
        $rc_string = str_replace('%0F%', $r_char, $rc_string);        // | 0000 1111 | 017 |  15 |  0F |    SI          |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('%10%', $r_char, $rc_string);        // | 0001 0000 | 020 |  16 |  10 |    DLE         |
        $rc_string = str_replace('%11%', $r_char, $rc_string);        // | 0001 0001 | 021 |  17 |  11 |    DC1         |
        $rc_string = str_replace('%12%', $r_char, $rc_string);        // | 0001 0010 | 022 |  18 |  12 |    DC2         |
        $rc_string = str_replace('%13%', $r_char, $rc_string);        // | 0001 0011 | 023 |  19 |  13 |    DC3         |
        $rc_string = str_replace('%14%', $r_char, $rc_string);        // | 0001 0100 | 024 |  20 |  14 |    DC4         |
        $rc_string = str_replace('%15%', $r_char, $rc_string);        // | 0001 0101 | 025 |  21 |  15 |    NAK         |
        $rc_string = str_replace('%16%', $r_char, $rc_string);        // | 0001 0110 | 026 |  22 |  16 |    SYN         |
        $rc_string = str_replace('%17%', $r_char, $rc_string);        // | 0001 0111 | 027 |  23 |  17 |    ETB         |
        $rc_string = str_replace('%18%', $r_char, $rc_string);        // | 0001 1000 | 030 |  24 |  18 |    CAN         |
        $rc_string = str_replace('%19%', $r_char, $rc_string);        // | 0001 1001 | 031 |  25 |  19 |    EM          |
        $rc_string = str_replace('%1A%', $r_char, $rc_string);        // | 0001 1010 | 032 |  26 |  1A |    SUB         |
        $rc_string = str_replace('%1B%', $r_char, $rc_string);        // | 0001 1011 | 033 |  27 |  1B |    ESC         |
        $rc_string = str_replace('%1C%', $r_char, $rc_string);        // | 0001 1100 | 034 |  28 |  1C |    FS          |
        $rc_string = str_replace('%1D%', $r_char, $rc_string);        // | 0001 1101 | 035 |  29 |  1D |    GS          |
        $rc_string = str_replace('%1E%', $r_char, $rc_string);        // | 0001 1110 | 036 |  30 |  1E |    RS          |
        $rc_string = str_replace('%1F%', $r_char, $rc_string);        // | 0001 1111 | 037 |  31 |  1F |    US          |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('%20%', $r_char, $rc_string);        // | 0010 0000 | 040 |  32 |  20 | (space)        |
        $rc_string = str_replace('%21%', $r_char, $rc_string);        // | 0010 0001 | 041 |  33 |  21 |    !           |
        $rc_string = str_replace('%22%', $r_char, $rc_string);        // | 0010 0010 | 042 |  34 |  22 |    "           |
        $rc_string = str_replace('%23%', $r_char, $rc_string);        // | 0010 0011 | 043 |  35 |  23 |    #           |
        $rc_string = str_replace('%24%', $r_char, $rc_string);        // | 0010 0100 | 044 |  36 |  24 |    $           |
        $rc_string = str_replace('%25%', $r_char, $rc_string);        // | 0010 0101 | 045 |  37 |  25 |    %           |
        $rc_string = str_replace('%26%', $r_char, $rc_string);        // | 0010 0110 | 046 |  38 |  26 |    &           |
        $rc_string = str_replace('%27%', $r_char, $rc_string);        // | 0010 0111 | 047 |  39 |  27 |    '           |
        $rc_string = str_replace('%28%', $r_char, $rc_string);        // | 0010 1000 | 050 |  40 |  28 |    (           |
        $rc_string = str_replace('%29%', $r_char, $rc_string);        // | 0010 1001 | 051 |  41 |  29 |    )           |
        $rc_string = str_replace('%2A%', $r_char, $rc_string);        // | 0010 1010 | 052 |  42 |  2A |    *           |
        $rc_string = str_replace('%2B%', $r_char, $rc_string);        // | 0010 1011 | 053 |  43 |  2B |    +           |
        $rc_string = str_replace('%2C%', $r_char, $rc_string);        // | 0010 1100 | 054 |  44 |  2C |    ,           |
        $rc_string = str_replace('%2D%', $r_char, $rc_string);        // | 0010 1101 | 055 |  45 |  2D |    -           |
        $rc_string = str_replace('%2E%', $r_char, $rc_string);        // | 0010 1110 | 056 |  46 |  2E |    .           |
        $rc_string = str_replace('%2F%', $r_char, $rc_string);        // | 0010 1111 | 057 |  47 |  2F |    /           |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('%3A%', $r_char, $rc_string);        // | 0011 1010 | 072 |  58 |  3A |    :           |
        $rc_string = str_replace('%3B%', $r_char, $rc_string);        // | 0011 1011 | 073 |  59 |  3B |    ;           |
        $rc_string = str_replace('%3C%', $r_char, $rc_string);        // | 0011 1100 | 074 |  60 |  3C |    <           |
        $rc_string = str_replace('%3D%', $r_char, $rc_string);        // | 0011 1101 | 075 |  61 |  3D |    =           |
        $rc_string = str_replace('%3E%', $r_char, $rc_string);        // | 0011 1110 | 076 |  62 |  3E |    >           |
        $rc_string = str_replace('%3F%', $r_char, $rc_string);        // | 0011 1111 | 077 |  63 |  3F |    ?           |
        $rc_string = str_replace('%40%', $r_char, $rc_string);        // | 0100 0000 | 080 |  64 |  40 |    @           |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('%5B%', $r_char, $rc_string);        // | 0101 1011 | 133 |  91 |  5B |    [           |
        $rc_string = str_replace('%5C%', $r_char, $rc_string);        // | 0101 1100 | 134 |  92 |  5C |    \           |
        $rc_string = str_replace('%5D%', $r_char, $rc_string);        // | 0101 1101 | 135 |  93 |  5D |    ]           |
        $rc_string = str_replace('%5E%', $r_char, $rc_string);        // | 0101 1110 | 136 |  94 |  5E |    ^           |
        $rc_string = str_replace('%5F%', $r_char, $rc_string);        // | 0101 1111 | 137 |  95 |  5F |    _           |
        $rc_string = str_replace('%60%', $r_char, $rc_string);        // | 0110 0000 | 140 |  96 |  60 |    `           |
        $rc_string = str_replace('%5F%', $r_char, $rc_string);        // | 0101 1111 | 137 |  95 |  5F |    _           |
        $rc_string = str_replace('%60%', $r_char, $rc_string);        // | 0110 0000 | 140 |  96 |  60 |    `           |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('%7B%', $r_char, $rc_string);        // | 0111 1011 | 173 | 123 |  7B |    {           |
        $rc_string = str_replace('%7C%', $r_char, $rc_string);        // | 0111 1100 | 174 | 124 |  7C |    |           |
        $rc_string = str_replace('%7D%', $r_char, $rc_string);        // | 0111 1101 | 175 | 125 |  7D |    }           |
        $rc_string = str_replace('%7E%', $r_char, $rc_string);        // | 0111 1110 | 176 | 126 |  7E |    ~           |
        $rc_string = str_replace('%7F%', $r_char, $rc_string);        // | 0111 1111 | 177 | 127 |  7F |    DEL         |
                                                                      // ------------------------------------------------
        //******************************************************************************************
        return $rc_string;
    }
    //**********************************************************************************************

    //**********************************************************************************************
    // (2017/05/25) Page 0009 , chr_char_replace($s_str)
    //              Parameter : (string) $s_str : 輸入的字串資訊 ;
    //              Return    : (string) 取代後的字串資訊 ;
    //              Description :  chr_char_replace($s_str) , 取代 chr 字元格式的 "不正常" 字元
    //**********************************************************************************************
    function chr_char_replace($s_str) {
        $rc_string = $s_str;  $r_char = 'n';                          // ------------------------------------------------
        //************************************************************// |  binary   | oct | dec | hex | glyh / abbr    |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('chr(0)', $r_char, $rc_string);      // | 0000 0000 | 000 |   0 |  00 |    NUL (\0)    |
        $rc_string = str_replace('chr(1)', $r_char, $rc_string);      // | 0000 0001 | 001 |   1 |  01 |    SOH         |
        $rc_string = str_replace('chr(2)', $r_char, $rc_string);      // | 0000 0010 | 002 |   2 |  02 |    STX         |
        $rc_string = str_replace('chr(3)', $r_char, $rc_string);      // | 0000 0011 | 003 |   3 |  03 |    ETX         |
        $rc_string = str_replace('chr(4)', $r_char, $rc_string);      // | 0000 0100 | 004 |   4 |  04 |    EOT         |
        $rc_string = str_replace('chr(5)', $r_char, $rc_string);      // | 0000 0101 | 005 |   5 |  05 |    ENQ         |
        $rc_string = str_replace('chr(6)', $r_char, $rc_string);      // | 0000 0110 | 006 |   6 |  06 |    ACK         |
        $rc_string = str_replace('chr(7)', $r_char, $rc_string);      // | 0000 0111 | 007 |   7 |  07 |    BEL (\a)    |
        $rc_string = str_replace('chr(8)', $r_char, $rc_string);      // | 0000 1000 | 010 |   8 |  08 |    BS  (\b)    |
        $rc_string = str_replace('chr(9)', $r_char, $rc_string);      // | 0000 1001 | 011 |   9 |  09 |    HT  (\t)    |
        $rc_string = str_replace('chr(10)', $r_char, $rc_string);     // | 0000 1010 | 012 |  10 |  0A |    LF  (\n)    |
        $rc_string = str_replace('chr(11)', $r_char, $rc_string);     // | 0000 1011 | 013 |  11 |  0B |    VT  (\v)    |
        $rc_string = str_replace('chr(12)', $r_char, $rc_string);     // | 0000 1100 | 014 |  12 |  0C |    FF  (\f)    |
        $rc_string = str_replace('chr(13)', $r_char, $rc_string);     // | 0000 1101 | 015 |  13 |  0D |    CR  (\r)    |
        $rc_string = str_replace('chr(14)', $r_char, $rc_string);     // | 0000 1110 | 016 |  14 |  0E |    SO          |
        $rc_string = str_replace('chr(15)', $r_char, $rc_string);     // | 0000 1111 | 017 |  15 |  0F |    SI          |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('chr(16)', $r_char, $rc_string);     // | 0001 0000 | 020 |  16 |  10 |    DLE         |
        $rc_string = str_replace('chr(17)', $r_char, $rc_string);     // | 0001 0001 | 021 |  17 |  11 |    DC1         |
        $rc_string = str_replace('chr(18)', $r_char, $rc_string);     // | 0001 0010 | 022 |  18 |  12 |    DC2         |
        $rc_string = str_replace('chr(19)', $r_char, $rc_string);     // | 0001 0011 | 023 |  19 |  13 |    DC3         |
        $rc_string = str_replace('chr(20)', $r_char, $rc_string);     // | 0001 0100 | 024 |  20 |  14 |    DC4         |
        $rc_string = str_replace('chr(21)', $r_char, $rc_string);     // | 0001 0101 | 025 |  21 |  15 |    NAK         |
        $rc_string = str_replace('chr(22)', $r_char, $rc_string);     // | 0001 0110 | 026 |  22 |  16 |    SYN         |
        $rc_string = str_replace('chr(23)', $r_char, $rc_string);     // | 0001 0111 | 027 |  23 |  17 |    ETB         |
        $rc_string = str_replace('chr(24)', $r_char, $rc_string);     // | 0001 1000 | 030 |  24 |  18 |    CAN         |
        $rc_string = str_replace('chr(25)', $r_char, $rc_string);     // | 0001 1001 | 031 |  25 |  19 |    EM          |
        $rc_string = str_replace('chr(26)', $r_char, $rc_string);     // | 0001 1010 | 032 |  26 |  1A |    SUB         |
        $rc_string = str_replace('chr(27)', $r_char, $rc_string);     // | 0001 1011 | 033 |  27 |  1B |    ESC         |
        $rc_string = str_replace('chr(28)', $r_char, $rc_string);     // | 0001 1100 | 034 |  28 |  1C |    FS          |
        $rc_string = str_replace('chr(29)', $r_char, $rc_string);     // | 0001 1101 | 035 |  29 |  1D |    GS          |
        $rc_string = str_replace('chr(30)', $r_char, $rc_string);     // | 0001 1110 | 036 |  30 |  1E |    RS          |
        $rc_string = str_replace('chr(29)', $r_char, $rc_string);     // | 0001 1101 | 035 |  29 |  1D |    GS          |
        $rc_string = str_replace('chr(30)', $r_char, $rc_string);     // | 0001 1110 | 036 |  30 |  1E |    RS          |
        $rc_string = str_replace('chr(31)', $r_char, $rc_string);     // | 0001 1111 | 037 |  31 |  1F |    US          |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('chr(32)', $r_char, $rc_string);     // | 0010 0000 | 040 |  32 |  20 | (space)        |
        $rc_string = str_replace('chr(33)', $r_char, $rc_string);     // | 0010 0001 | 041 |  33 |  21 |    !           |
        $rc_string = str_replace('chr(34)', $r_char, $rc_string);     // | 0010 0010 | 042 |  34 |  22 |    "           |
        $rc_string = str_replace('chr(35)', $r_char, $rc_string);     // | 0010 0011 | 043 |  35 |  23 |    #           |
        $rc_string = str_replace('chr(36)', $r_char, $rc_string);     // | 0010 0100 | 044 |  36 |  24 |    $           |
        $rc_string = str_replace('chr(37)', $r_char, $rc_string);     // | 0010 0101 | 045 |  37 |  25 |    %           |
        $rc_string = str_replace('chr(38)', $r_char, $rc_string);     // | 0010 0110 | 046 |  38 |  26 |    &           |
        $rc_string = str_replace('chr(39)', $r_char, $rc_string);     // | 0010 0111 | 047 |  39 |  27 |    '           |
        $rc_string = str_replace('chr(40)', $r_char, $rc_string);     // | 0010 1000 | 050 |  40 |  28 |    (           |
        $rc_string = str_replace('chr(41)', $r_char, $rc_string);     // | 0010 1001 | 051 |  41 |  29 |    )           |
        $rc_string = str_replace('chr(42)', $r_char, $rc_string);     // | 0010 1010 | 052 |  42 |  2A |    *           |
        $rc_string = str_replace('chr(43)', $r_char, $rc_string);     // | 0010 1011 | 053 |  43 |  2B |    +           |
        $rc_string = str_replace('chr(44)', $r_char, $rc_string);     // | 0010 1100 | 054 |  44 |  2C |    ,           |
        $rc_string = str_replace('chr(45)', $r_char, $rc_string);     // | 0010 1101 | 055 |  45 |  2D |    -           |
        $rc_string = str_replace('chr(46)', $r_char, $rc_string);     // | 0010 1110 | 056 |  46 |  2E |    .           |
        $rc_string = str_replace('chr(47)', $r_char, $rc_string);     // | 0010 1111 | 057 |  47 |  2F |    /           |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('chr(58)', $r_char, $rc_string);     // | 0011 1010 | 072 |  58 |  3A |    :           |
        $rc_string = str_replace('chr(59)', $r_char, $rc_string);     // | 0011 1011 | 073 |  59 |  3B |    ;           |
        $rc_string = str_replace('chr(60)', $r_char, $rc_string);     // | 0011 1100 | 074 |  60 |  3C |    <           |
        $rc_string = str_replace('chr(61)', $r_char, $rc_string);     // | 0011 1101 | 075 |  61 |  3D |    =           |
        $rc_string = str_replace('chr(62)', $r_char, $rc_string);     // | 0011 1110 | 076 |  62 |  3E |    >           |
        $rc_string = str_replace('chr(63)', $r_char, $rc_string);     // | 0011 1111 | 077 |  63 |  3F |    ?           |
        $rc_string = str_replace('chr(64)', $r_char, $rc_string);     // | 0100 0000 | 080 |  64 |  40 |    @           |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('chr(91)', $r_char, $rc_string);     // | 0101 1011 | 133 |  91 |  5B |    [           |
        $rc_string = str_replace('chr(92)', $r_char, $rc_string);     // | 0101 1100 | 134 |  92 |  5C |    \           |
        $rc_string = str_replace('chr(93)', $r_char, $rc_string);     // | 0101 1101 | 135 |  93 |  5D |    ]           |
        $rc_string = str_replace('chr(94)', $r_char, $rc_string);     // | 0101 1110 | 136 |  94 |  5E |    ^           |
        $rc_string = str_replace('chr(95)', $r_char, $rc_string);     // | 0101 1111 | 137 |  95 |  5F |    _           |
        $rc_string = str_replace('chr(96)', $r_char, $rc_string);     // | 0110 0000 | 140 |  96 |  60 |    `           |
                                                                      // ------------------------------------------------
        $rc_string = str_replace('chr(123)', $r_char, $rc_string);    // | 0111 1011 | 173 | 123 |  7B |    {           |
        $rc_string = str_replace('chr(124)', $r_char, $rc_string);    // | 0111 1100 | 174 | 124 |  7C |    |           |
        $rc_string = str_replace('chr(125)', $r_char, $rc_string);    // | 0111 1101 | 175 | 125 |  7D |    }           |
        $rc_string = str_replace('chr(126)', $r_char, $rc_string);    // | 0111 1110 | 176 | 126 |  7E |    ~           |
        $rc_string = str_replace('chr(127)', $r_char, $rc_string);    // | 0111 1111 | 177 | 127 |  7F |    DEL         |
                                                                      // ------------------------------------------------
        //******************************************************************************************
        return $rc_string;
    }
    //**********************************************************************************************

    //**********************************************************************************************
    // (2017/05/25) Page 0010 , ascii_char_replace($s_str)
    //              Parameter : (string) $s_str : 輸入的字串資訊 ;
    //              Return    : (string) 取代後的字串資訊 ;
    //              Description :  ascii_char_replace($s_str) , 取代一般格式的 "不正常" 字元
    //**********************************************************************************************
    function ascii_char_replace($s_str) {
        $rc_string = $s_str;  $r_char = 'n';
        //******************************************************************************************
        $rc_string = $s_str;  $r_char = 'n';
        //******************************************************************************************
        $rc_string = str_replace('CHR(', $r_char, $rc_string);
        $rc_string = str_replace('chr(', $r_char, $rc_string);
        $rc_string = str_replace('CHr(', $r_char, $rc_string);
        $rc_string = str_replace('ChR(', $r_char, $rc_string);
        $rc_string = str_replace('cHR(', $r_char, $rc_string);
        $rc_string = str_replace('Chr(', $r_char, $rc_string);
        $rc_string = str_replace('cHr(', $r_char, $rc_string);
        $rc_string = str_replace('chR(', $r_char, $rc_string);
        //******************************************************************************************
        $rc_string = str_replace(' OR ', $r_char, $rc_string);
        $rc_string = str_replace(' Or ', $r_char, $rc_string);
        $rc_string = str_replace(' oR ', $r_char, $rc_string);
        $rc_string = str_replace(' or ', $r_char, $rc_string);
        //******************************************************************************************
        $rc_string = str_replace(' AND ', $r_char, $rc_string);
        $rc_string = str_replace(' ANd ', $r_char, $rc_string);
        $rc_string = str_replace(' AnD ', $r_char, $rc_string);
        $rc_string = str_replace(' aND ', $r_char, $rc_string);
        $rc_string = str_replace(' And ', $r_char, $rc_string);
        $rc_string = str_replace(' anD ', $r_char, $rc_string);
        $rc_string = str_replace(' aNd ', $r_char, $rc_string);
        $rc_string = str_replace(' and ', $r_char, $rc_string);
        //******************************************************************************************
        $rc_string = str_replace('--', $r_char, $rc_string);
        $rc_string = str_replace('/*', $r_char, $rc_string);
        $rc_string = str_replace('*/', $r_char, $rc_string);
        //******************************************************************************************
        return $rc_string;
    }
    //**********************************************************************************************
//**************************************************************************************************
?>
