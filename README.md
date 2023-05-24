# PHP-WHOIS
PHP를 이용하여 도메인의 WHOIS 정보를 Lookup합니다

## 사용방법

```php
require_once "WHOIS.php";
// WHOIS Class가 포함된 PHP코드를 Include합니다

$WHOIS = new WHOIS("WHOIS_SERVERS.json");
// TLD마다 WHOIS 서버 정보가 포함된 설정 파일입니다

$WHOIS->FIND_WHOIS_SERVER("kr");
// 해당 TLD의 후이즈 서버를 IANA 웹사이트에서 찾은후 설정파일에 추가합니다
// 만약 설정파일에 이미 해당 TLD에 대한 후이즈 정보가 있다면 추가를 안합니다

$WHOIS->WHOIS("renyu.ac.kr");
// 도메인의 WHOIS 정보를 Lookup합니다

$WHOIS->IP_INFO("1.1.1.1");
// Apanic, Ripe, Afrinic, Lacnic, Arin 후이즈 서버에서 해당 아이피의 정보를 Lookup합니다

```

## Functions

## $WHOIS->WHOIS()
`$WHOIS->WHOIS()`은 도메인의 WHOIS 정보를 Lookup할때 사용합니다<br>
RETURN할때는 ARRAY 형태로 RETURN합니다

### CALL
```php
$WHOIS->WHOIS("renyu.ac.kr")
```

### RETURN (ARRAY TO JSON)
```json
{
  "STATUS": "OK",
  "MSG": "WHOIS SERVER FOUND",
  "DOMAIN": "renyu.ac.kr",
  "WHOIS_SERVER": "whois.nic.or.kr",
  "RESULT": "query : renyu.ac.kr\n\n\n# KOREAN(UTF8)\n\n도메인이름 : renyu.ac.kr\n등록인 : Domain Privacy Services\n책임자 : Domain Privacy Services\n책임자 전자우편 : DomainPrivacy@HOSTING.KR\n등록일 : 2023. 03. 31.\n최근 정보 변경일 : 2023. 04. 24.\n사용 종료일 : 2025. 03. 31.\n정보공개여부 : N\n등록대행자 : 메가존(주)(http://HOSTING.KR)\nDNSSEC : 미서명\n등록정보 보호 : clientTransferProhibited\n\n1차 네임서버 정보\n 호스트이름 : brett.ns.cloudflare.com\n\n2차 네임서버 정보\n 호스트이름 : liberty.ns.cloudflare.com\n\n네임서버 이름이 .kr이 아닌 경우는 IP주소가 보이지 않습니다.\n\n\n# ENGLISH\n\nDomain Name : renyu.ac.kr\nRegistrant : Domain Privacy Services\nAdministrative Contact(AC) : Domain Privacy Services\nAC E-Mail : DomainPrivacy@HOSTING.KR\nRegistered Date : 2023. 03. 31.\nLast Updated Date : 2023. 04. 24.\nExpiration Date : 2025. 03. 31.\nPublishes : N\nAuthorized Agency : Megazone(http://HOSTING.KR)\nDNSSEC : unsigned\nDomain Status : clientTransferProhibited\n\nPrimary Name Server\n Host Name : brett.ns.cloudflare.com\n\nSecondary Name Server\n Host Name : liberty.ns.cloudflare.com\n\n\n- KISA/KRNIC WHOIS Service -\n\n"
}
```

##### RETURN Param
|KEY|VALUE|
|-|--|
|STATUS|처리 상태를 뜻합니다 `OK` 또는 `ERR`로 RETURN합니다|
|MSG|처리후 처리 메시지를 뜻합니다|
|DOMAIN|Lookup한 도메인을 뜻합니다|
|WHOIS_SERVER|Lookup한 WHOIS 서버를 뜻합니다|
|RESULT|후이즈 정보를 뜻합니다|

## $WHOIS->FIND_WHOIS_SERVER()
후이즈 서버 정보가 없을때 사용하는 Function입니다
사용시 IANA 웹사이트에서 WHOIS 서버 정보를 찾은후 TLD마다 WHOIS 서버 정보가 포함된 설정 파일에 추가합니다

### CALL
```php
$WHOIS->FIND_WHOIS_SERVER("kr");
```

### RETURN (ARRAY TO JSON)
```json
{
  "STATUS": "OK",
  "MSG": "WHOIS SERVER FOUND",
  "WHOIS_SERVER": "whois.nic.or.kr"
}
```

##### RETURN Param
|KEY|VALUE|
|-|--|
|STATUS|처리 상태를 뜻합니다 `OK` 또는 `ERR`로 표시합니다|
|MSG|처리후 처리 메시지를 표시합니다|
|WHOIS_SERVER|Lookup한 WHOIS 서버를 표시합니다|


## $WHOIS->IP_INFO()

### CALL
```php
$WHOIS->IP_INFO("1.1.1.1");
$WHOIS->IP_INFO("1.1.1.1", "ALL");

$WHOIS->IP_INFO("1.1.1.1", "whois.kr"); // 특정 후이즈 서버(whois.kr)로 Lookup을 합니다
```

### RETURN (ARRAY TO JSON)
```json
{
  "STATUS": "OK",
  "IP": "1.1.1.1",
  "WHOIS_SERVER": [
    "whois.apnic.net",
    "whois.ripe.net",
    "whois.afrinic.net",
    "whois.lacnic.net",
    "whois.arin.net"
  ],
  "RESULT": {
    "whois.apnic.net": "% [whois.apnic.net]\n% Whois data copyright terms http://www.apnic.net/db/dbcopyright.html\n\n% Information related to '1.1.1.0 - 1.1.1.255'\n\n% Abuse contact for '1.1.1.0 - 1.1.1.255' is 'helpdesk@apnic.net'\n\ninetnum: 1.1.1.0 - 1.1.1.255\nnetname: APNIC-LABS\ndescr: APNIC and Cloudflare DNS Resolver project\ndescr: Routed globally by AS13335/Cloudflare\ndescr: Research prefix for APNIC Labs\ncountry: AU\norg: ORG-ARAD1-AP\nadmin-c: AIC3-AP\ntech-c: AIC3-AP\nabuse-c: AA1412-AP\nstatus: ASSIGNED PORTABLE\nremarks: ---------------\nremarks: All Cloudflare abuse reporting can be done via\nremarks: resolver-abuse@cloudflare.com\nremarks: ---------------\nmnt-by: APNIC-HM\nmnt-routes: MAINT-APNICRANDNET\nmnt-irt: IRT-APNICRANDNET-AU\nlast-modified: 2023-04-26T22:57:58Z\nmnt-lower: MAINT-APNICRANDNET\nsource: APNIC\n\nirt: IRT-APNICRANDNET-AU\naddress: PO Box 3646\naddress: South Brisbane, QLD 4101\naddress: Australia\ne-mail: helpdesk@apnic.net\nabuse-mailbox: helpdesk@apnic.net\nadmin-c: AR302-AP\ntech-c: AR302-AP\nauth: # Filtered\nremarks: helpdesk@apnic.net was validated on 2021-02-09\nmnt-by: MAINT-AU-APNIC-GM85-AP\nlast-modified: 2021-03-09T01:10:21Z\nsource: APNIC\n\norganisation: ORG-ARAD1-AP\norg-name: APNIC Research and Development\ncountry: AU\naddress: 6 Cordelia St\nphone: +61-7-38583100\nfax-no: +61-7-38583199\ne-mail: helpdesk@apnic.net\nmnt-ref: APNIC-HM\nmnt-by: APNIC-HM\nlast-modified: 2017-10-11T01:28:39Z\nsource: APNIC\n\nrole: ABUSE APNICRANDNETAU\naddress: PO Box 3646\naddress: South Brisbane, QLD 4101\naddress: Australia\ncountry: ZZ\nphone: +000000000\ne-mail: helpdesk@apnic.net\nadmin-c: AR302-AP\ntech-c: AR302-AP\nnic-hdl: AA1412-AP\nremarks: Generated from irt object IRT-APNICRANDNET-AU\nabuse-mailbox: helpdesk@apnic.net\nmnt-by: APNIC-ABUSE\nlast-modified: 2021-03-09T01:10:22Z\nsource: APNIC\n\nrole: APNICRANDNET Infrastructure Contact\naddress: 6 Cordelia St\n South Brisbane\n QLD 4101\ncountry: AU\nphone: +61 7 3858 3100\ne-mail: research@apnic.net\nadmin-c: GM85-AP\nadmin-c: GH173-AP\nadmin-c: JD1186-AP\ntech-c: GM85-AP\ntech-c: GH173-AP\ntech-c: JD1186-AP\nnic-hdl: AIC3-AP\nmnt-by: MAINT-APNICRANDNET\nlast-modified: 2023-04-26T22:50:54Z\nsource: APNIC\n\n% Information related to '1.1.1.0/24AS13335'\n\nroute: 1.1.1.0/24\norigin: AS13335\ndescr: APNIC Research and Development\n 6 Cordelia St\nmnt-by: MAINT-APNICRANDNET\nlast-modified: 2023-04-26T02:42:44Z\nsource: APNIC\n\n% This query was served by the APNIC Whois Service version 1.88.16 (WHOIS-JP3)\n\n\n",
    "whois.ripe.net": "% This is the RIPE Database query service.\n% The objects are in RPSL format.\n%\n% The RIPE Database is subject to Terms and Conditions.\n% See http://www.ripe.net/db/support/db-terms-conditions.pdf\n\n% Note: this output has been filtered.\n% To receive output for a database update, use the \"-B\" flag.\n\n% Information related to '0.0.0.0 - 1.178.111.255'\n\n% No abuse contact registered for 0.0.0.0 - 1.178.111.255\n\ninetnum: 0.0.0.0 - 1.178.111.255\nnetname: NON-RIPE-NCC-MANAGED-ADDRESS-BLOCK\ndescr: IPv4 address block not managed by the RIPE NCC\nremarks: ------------------------------------------------------\nremarks:\nremarks: For registration information,\nremarks: you can consult the following sources:\nremarks:\nremarks: IANA\nremarks: http://www.iana.org/assignments/ipv4-address-space\nremarks: http://www.iana.org/assignments/iana-ipv4-special-registry\nremarks: http://www.iana.org/assignments/ipv4-recovered-address-space\nremarks:\nremarks: AFRINIC (Africa)\nremarks: http://www.afrinic.net/ whois.afrinic.net\nremarks:\nremarks: APNIC (Asia Pacific)\nremarks: http://www.apnic.net/ whois.apnic.net\nremarks:\nremarks: ARIN (Northern America)\nremarks: http://www.arin.net/ whois.arin.net\nremarks:\nremarks: LACNIC (Latin America and the Carribean)\nremarks: http://www.lacnic.net/ whois.lacnic.net\nremarks:\nremarks: ------------------------------------------------------\ncountry: EU # Country is really world wide\nadmin-c: IANA1-RIPE\ntech-c: IANA1-RIPE\nstatus: ALLOCATED UNSPECIFIED\nmnt-by: RIPE-NCC-HM-MNT\ncreated: 2021-12-06T15:26:36Z\nlast-modified: 2021-12-06T15:26:36Z\nsource: RIPE\n\nrole: Internet Assigned Numbers Authority\naddress: see http://www.iana.org.\nadmin-c: IANA1-RIPE\ntech-c: IANA1-RIPE\nnic-hdl: IANA1-RIPE\nremarks: For more information on IANA services\nremarks: go to IANA web site at http://www.iana.org.\nmnt-by: RIPE-NCC-MNT\ncreated: 1970-01-01T00:00:00Z\nlast-modified: 2001-09-22T09:31:27Z\nsource: RIPE # Filtered\n\n% This query was served by the RIPE Database Query Service version 1.106.1 (BUSA)\n\n\n",
    "whois.afrinic.net": "% This is the AfriNIC Whois server.\n% The AFRINIC whois database is subject to the following terms of Use. See https://afrinic.net/whois/terms\n\n% Note: this output has been filtered.\n% To receive output for a database update, use the \"-B\" flag.\n\n% The WHOIS is temporary unable to query APNIC for the requested resource. Please try again later.\n\n\n",
    "whois.lacnic.net": "% IP Client: 112.173.144.40\n % [whois.apnic.net]\n% Whois data copyright terms http://www.apnic.net/db/dbcopyright.html\n\n% Information related to '1.1.1.0 - 1.1.1.255'\n\n% Abuse contact for '1.1.1.0 - 1.1.1.255' is 'helpdesk@apnic.net'\n\ninetnum: 1.1.1.0 - 1.1.1.255\nnetname: APNIC-LABS\ndescr: APNIC and Cloudflare DNS Resolver project\ndescr: Routed globally by AS13335/Cloudflare\ndescr: Research prefix for APNIC Labs\ncountry: AU\norg: ORG-ARAD1-AP\nadmin-c: AIC3-AP\ntech-c: AIC3-AP\nabuse-c: AA1412-AP\nstatus: ASSIGNED PORTABLE\nremarks: ---------------\nremarks: All Cloudflare abuse reporting can be done via\nremarks: resolver-abuse@cloudflare.com\nremarks: ---------------\nmnt-by: APNIC-HM\nmnt-routes: MAINT-APNICRANDNET\nmnt-irt: IRT-APNICRANDNET-AU\nlast-modified: 2023-04-26T22:57:58Z\nmnt-lower: MAINT-APNICRANDNET\nsource: APNIC\n\nirt: IRT-APNICRANDNET-AU\naddress: PO Box 3646\naddress: South Brisbane, QLD 4101\naddress: Australia\ne-mail: helpdesk@apnic.net\nabuse-mailbox: helpdesk@apnic.net\nadmin-c: AR302-AP\ntech-c: AR302-AP\nauth: # Filtered\nremarks: helpdesk@apnic.net was validated on 2021-02-09\nmnt-by: MAINT-AU-APNIC-GM85-AP\nlast-modified: 2021-03-09T01:10:21Z\nsource: APNIC\n\norganisation: ORG-ARAD1-AP\norg-name: APNIC Research and Development\ncountry: AU\naddress: 6 Cordelia St\nphone: +61-7-38583100\nfax-no: +61-7-38583199\ne-mail: helpdesk@apnic.net\nmnt-ref: APNIC-HM\nmnt-by: APNIC-HM\nlast-modified: 2017-10-11T01:28:39Z\nsource: APNIC\n\nrole: ABUSE APNICRANDNETAU\naddress: PO Box 3646\naddress: South Brisbane, QLD 4101\naddress: Australia\ncountry: ZZ\nphone: +000000000\ne-mail: helpdesk@apnic.net\nadmin-c: AR302-AP\ntech-c: AR302-AP\nnic-hdl: AA1412-AP\nremarks: Generated from irt object IRT-APNICRANDNET-AU\nabuse-mailbox: helpdesk@apnic.net\nmnt-by: APNIC-ABUSE\nlast-modified: 2021-03-09T01:10:22Z\nsource: APNIC\n\nrole: APNICRANDNET Infrastructure Contact\naddress: 6 Cordelia St\n South Brisbane\n QLD 4101\ncountry: AU\nphone: +61 7 3858 3100\ne-mail: research@apnic.net\nadmin-c: GM85-AP\nadmin-c: GH173-AP\nadmin-c: JD1186-AP\ntech-c: GM85-AP\ntech-c: GH173-AP\ntech-c: JD1186-AP\nnic-hdl: AIC3-AP\nmnt-by: MAINT-APNICRANDNET\nlast-modified: 2023-04-26T22:50:54Z\nsource: APNIC\n\n% Information related to '1.1.1.0/24AS13335'\n\nroute: 1.1.1.0/24\norigin: AS13335\ndescr: APNIC Research and Development\n 6 Cordelia St\nmnt-by: MAINT-APNICRANDNET\nlast-modified: 2023-04-26T02:42:44Z\nsource: APNIC\n\n% This query was served by the APNIC Whois Service version 1.88.16 (WHOIS-US3)\n\n\n",
    "whois.arin.net": "\n#\n# ARIN WHOIS data and services are subject to the Terms of Use\n# available at: https://www.arin.net/resources/registry/whois/tou/\n#\n# If you see inaccuracies in the results, please report at\n# https://www.arin.net/resources/registry/whois/inaccuracy_reporting/\n#\n# Copyright 1997-2023, American Registry for Internet Numbers, Ltd.\n#\n\n\n#\n# Query terms are ambiguous. The query is assumed to be:\n# \"n 1.1.1.1\"\n#\n# Use \"?\" to get help.\n#\n\nNetRange: 1.0.0.0 - 1.255.255.255\nCIDR: 1.0.0.0/8\nNetName: APNIC-1\nNetHandle: NET-1-0-0-0-1\nParent: ()\nNetType: Allocated to APNIC\nOriginAS: \nOrganization: Asia Pacific Network Information Centre (APNIC)\nRegDate: \nUpdated: 2010-07-30\nComment: This IP address range is not registered in the ARIN database.\nComment: For details, refer to the APNIC Whois Database via\nComment: WHOIS.APNIC.NET or http://wq.apnic.net/apnic-bin/whois.pl\nComment: ** IMPORTANT NOTE: APNIC is the Regional Internet Registry\nComment: for the Asia Pacific region. APNIC does not operate networks\nComment: using this IP address range and is not able to investigate\nComment: spam or abuse reports relating to these addresses. For more\nComment: help, refer to http://www.apnic.net/apnic-info/whois_search2/abuse-and-spamming\nRef: https://rdap.arin.net/registry/ip/1.0.0.0\n\nResourceLink: http://wq.apnic.net/whois-search/static/search.html\nResourceLink: whois.apnic.net\n\n\nOrgName: Asia Pacific Network Information Centre\nOrgId: APNIC\nAddress: PO Box 3646\nCity: South Brisbane\nStateProv: QLD\nPostalCode: 4101\nCountry: AU\nRegDate: \nUpdated: 2012-01-24\nRef: https://rdap.arin.net/registry/entity/APNIC\n\nReferralServer: whois://whois.apnic.net\nResourceLink: http://wq.apnic.net/whois-search/static/search.html\n\nOrgTechHandle: AWC12-ARIN\nOrgTechName: APNIC Whois Contact\nOrgTechPhone: +61 7 3858 3188 \nOrgTechEmail: search-apnic-not-arin@apnic.net\nOrgTechRef: https://rdap.arin.net/registry/entity/AWC12-ARIN\n\nOrgAbuseHandle: AWC12-ARIN\nOrgAbuseName: APNIC Whois Contact\nOrgAbusePhone: +61 7 3858 3188 \nOrgAbuseEmail: search-apnic-not-arin@apnic.net\nOrgAbuseRef: https://rdap.arin.net/registry/entity/AWC12-ARIN\n\n\n#\n# ARIN WHOIS data and services are subject to the Terms of Use\n# available at: https://www.arin.net/resources/registry/whois/tou/\n#\n# If you see inaccuracies in the results, please report at\n# https://www.arin.net/resources/registry/whois/inaccuracy_reporting/\n#\n# Copyright 1997-2023, American Registry for Internet Numbers, Ltd.\n#\n\n"
  }
}
```

##### RETURN Param
|KEY|VALUE|
|-|--|
|STATUS|처리 상태를 뜻합니다 `OK` 또는 `ERR`로 표시합니다|
|IP|Lookup한 IP를 표시합니다|
|MSG|처리후 처리 메시지를 표시합니다|
|WHOIS_SERVER|Lookup한 WHOIS 서버를 표시합니다|
|RESULT|각 WHOIS 서버마다 Lookup한 후이즈 정보를 표시합니다|
