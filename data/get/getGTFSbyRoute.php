<?php
//Pass Map ID by Map ID
ini_set("memory_limit","1500M");
ini_set('max_execution_time', 1200);
$routeID = $_GET["route"];
include '../../config/db.php'; 
$test = new db();
$inscon = $test->connect();

//$routes = [89,110,117,149,150,151,152,153,155,156,157,158,159,160,160,162,163,163];

//$routes =  ["1565","1566","1567","1568","1569","1570","1979","1980","1981","1982","1984","1986","1988","1990","1991","1992","1993","1995","1997","1999","2000","2004","2005","2006","2012","2013","2018","2019","2103","2104","2105","2106","2636","2637","2638","2639","2640","2641","2642","2644","2645","2646","2648","2649","2650","2651","2652","2653","2654","2655","2656","2657","2658","2659","2660","2661","2662","2663","2664","2665","2666","2667","2668","2669","2670","2671","2672","2673","2674","2675","2676","2677","2678","2679","2680","2681","2682","2683","2684","2685","2686","2687","2688","2689","2690","2691","2692","2693","2694","2695","2696","2697","2698","2699","2700","2715","2716","2717","2718","2719","2720","2721","2722","2723","2724","2725","2726","2727","2728","2729","2730","2731","2732","2733","2734","2735","2736","2737","2738","2739","2740","2741","2742","2743","2744","2745","2746","2747","2748","2749","2750","2751","2752","2753","2754","2755","2756","2757","2758","2759","2760","2761","2762","2763","2764","2765","2766","2767","2768","2769","2770","2771","2772","2773","2774","2775","2776","2777","2778","2779","2780","2781","2782","2783","2784","2785","2786","2787","2788","2789","2790","2791","2792","2793","2794","2795","2796","2797","2798","2799","2800","2801","2802","2803","2804","2805","2806","2807","2808","2809","2810","2811","2812","2813","2814","2815","2816","2817","2818","2819","2820","2821","2822","2823","2824","2825","2826","2828","2829","2830","2837","2838","2839","2840","2841","2842","2843","2844","2845","2846","2847","2848","2849","2850","2851","2852","2853","2854","2855","2856","2857","2858","2859","2860","2861","2862","2863","2864"];
//$routes = [1531,1532,1533,1534,1535,1536,1537,1538,1539,1540,1541,1542,1543,1544,1545,1546,1547,1548,1549,1550,1551,1552,1553,1554,1555,1556,1557,1558,1559,1560,1561,1562,1563,1564,1565,1566,1567,1568,1569,1570,1725,1726,1727,1728,1729,1730,1731,1732,1733,1734,1735,1736,1737,1738,1739,1740,1741,1742,1743,1744,1745,1746,1747,1748,1749,1750,1751,1752,1753,1754,1755,1756,1757,1758,1759,1760,1761,1762,1763,1764,1765,1766,1767,1768,1769,1770,1771,1772,1773,1774,1775,1776,1777,1778,1779,1780,1781,1782,1783,1784,1785,1786,1787,1788,1789,1790,1791,1792,1793,1794,1795,1796,1797,1798,1799,1800,1801,1802,1803,1804,1805,1806,1807,1808,1809,1810,1811,1812,1813,1814,1815,1816,1817,1818,1819,1820,1821,1822,1823,1824,1825,1826,1827,1828,1829,1830,1831,1832,1833,1834,1835,1836,1837,1838,1839,1840,1841,1842,1843,1844,1845,1846,1847,1848,1849,1850,1851,1852,1853,1854,1855,1856,1857,1858,1859,1860,1861,1862,1863,1864,1865,1866,1867,1868,1869,1870,1871,1872,1873,1874,1875,1876,1877,1878,1879,1880,1881,1882,1883,1884,1885,1886,1887,1888,1889,1890,1891,1892,1893,1894,1895,1896,1897,1898,1899,1900,1901,1902,1903,1904,1905,1906,1907,1908,1909,1910,1911,1912,1913,1914,1915,1916,1917,1918,1919,1920,1921,1922,1923,1924,1925,1926,1927,1928,1929,1930,1931,1932,1933,1934,1935,1936,1937,1938,1939,1940,1941,1942,1943,1944,1945,1946,1947,1948,1949,1950,1951,1952,1953,1954,1955,1956,1957,1958,1959,1960,1961,1962,1963,1964,1965,1966,1967,1968,1969,1970,1971,1972,1973,1974,1975,1976,1977,1978,1979,1980,1981,1982,1983,1984,1985,1986,1987,1988,1989,1990,1991,1992,1993,1994,1995,1996,1997,1998,1999,2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015,2016,2017,2018,2019,2020,2021,2031,2032,2033,2034,2035,2036,2037,2038,2039,2040,2041,2042,2043,2044,2045,2046,2047,2048,2049,2050,2051,2052,2053,2054,2055,2056,2057,2058,2059,2060,2061,2062,2063,2064,2065,2066,2067,2068,2069,2070,2071,2072,2073,2074,2075,2076,2077,2078,2079,2080,2081,2082,2083,2084,2085,2086,2087,2088,2089,2090,2091,2092,2093,2094,2095,2096,2097,2098,2099,2100,2101,2102,2104,2106,2107,2108,2109,2110,2111,2112,2113,2114,2115,2116,2117,2118,2119,2120,2121,2122,2123,2124,2125,2126,2127,2128,2129,2130,2131,2132,2133,2134,2135,2136,2137,2138,2139,2140,2141,2142,2143,2144,2145,2146,2147,2148,2149,2150,2151,2152,2153,2154,2155,2156,2157,2158,2159,2160,2161,2162,2163,2164,2165,2166,2167,2168,2169,2170,2171,2172,2173,2174,2175,2176,2177,2178,2391,2392,2394,2395,2396,2397,2398,2399,2401,2402,2403,2404,2405,2406,2407,2408,2410,2411,2412,2413,2414,2517,2518,2519,2520,2521,2522,2523,2524,2525,2526,2527,2528,2529,2530];

//newark
$routes = [1,3,4,56,7,8,8,9,10,11,12,24,25,26,27,28,29,30,31,32,33,77,78,79,80,82,85,90,95,96,97,98,99,100,111,130,147,164,167,169,172,181,184,186,197,201,203,246,247,248,249,250,250,252,261,262];

//patterson
//$routes = [35,36,37,45,46,48,50,51,63,65,69,70,72,173,174,175,179,182,182,183,184,185,187,188];

$output ['type'] = 'FeatureCollection';
 

//Sql call & json encod
foreach($routes as $route)
{


$sql = "select
trips.route_id as routeID,
count(distinct trips.trip_id) as numTrips,
count(distinct trips.service_id) numService,
shapes.shape_id,
shapes.shape_pt_lat,
shapes.shape_pt_lon,
shapes.shape_pt_sequence
FROM shapes,trips where shapes.shape_id = trips.shape_id
AND trips.route_id = $route
group by shapes.shape_id ,shapes.shape_pt_sequence
order by shapes.shape_id , shapes.shape_pt_sequence";

//echo $sql."<br><br>";

$rs=mysql_query($sql) or die($sql."<br><br>".mysql_error());

$results = array();
while ($row = mysql_fetch_assoc( $rs ))
{
    $curr_shape_id=$row['shape_id'];
    $properties = array();
    $feature = array();
    $geometry = array();
    $properties['id'] = $row['shape_id'];
    $properties['route'] = $row['routeID'];
    $properties['num_trips'] = $row['numTrips'];
    
    $feature['type'] = 'Feature';
    $feature['properties'] = $properties;
    $geometry['type'] = 'LineString'; 
    $coordinates[] = array();

    $x=0;
    $coordinates[] = array();
    //echo $curr_shape_id;
    while($row['shape_id'] == $curr_shape_id)
    {        
           //$geo = json_decode($geodata, true);
           if (!empty($row['shape_pt_lat']) && !empty($row['shape_pt_lon']))
           {
            $coordinates[$x][0] = floatval($row['shape_pt_lon']);
            $coordinates[$x][1] = floatval($row['shape_pt_lat']);
            }
           $x++;            
           $row = mysql_fetch_assoc( $rs );
    }

    $geometry['coordinates'] = $coordinates;
    $feature['geometry'] = $geometry;
    $output['features'][]=$feature;
    unset($coordinates);
}
}
echo json_encode($output); 

?>