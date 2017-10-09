


php-pecl-solr & php-pecl-solr2 的 Bug 

```
$client = new SolrClient($options);

$query = new \SolrQuery();
$query->setQuery('*:*');
$query->setFacet(TRUE);
$query->setStats(TRUE);
$query->addStatsField("{!tag=t1 sum=true}place_rental");
$query->addParam("facet.pivot", "{!stats=t1}province_id,staffer_id");

$query->setFacetOffset(2); //加上这一句后无返回，所以改用 curl 方式调用
$query->setFacetLimit(2);
```


