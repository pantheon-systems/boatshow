<?php

/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */
/**
  * if (file_exists('/var/www/site-php')) {
  *  require("/mnt/gfs/{$_ENV['AH_SITE_NAME']}/config/saml/saml20-idp-remote.php");
  * }
**/

 /**  Drupal local miami  **/
 $metadata['http://www.okta.com/exk1i01udoowqSkgi0h8'] = array (
   'entityid' => 'http://www.okta.com/exk1i01udoowqSkgi0h8',
   'contacts' =>
   array (
   ),
   'metadata-set' => 'saml20-idp-remote',
   'SingleSignOnService' =>
   array (
     0 =>
     array (
       'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
       'Location' => 'https://nmma.okta.com/app/nmma_drupallocalmiami_1/exk1i01udoowqSkgi0h8/sso/saml',
     ),
     1 =>
     array (
       'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
       'Location' => 'https://nmma.okta.com/app/nmma_drupallocalmiami_1/exk1i01udoowqSkgi0h8/sso/saml',
     ),
   ),
   'SingleLogoutService' =>
   array (
   ),
   'ArtifactResolutionService' =>
   array (
   ),
   'NameIDFormats' =>
   array (
     0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
   ),
   'keys' =>
   array (
     0 =>
     array (
       'encryption' => false,
       'signing' => true,
       'type' => 'X509Certificate',
       'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
 A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
 MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
 b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
 EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
 dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
 bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
 rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
 K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
 DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
 ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
 gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
 ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
 q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
 PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
 OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
 IGVezl2GnehhLt7m',
     ),
   ),
 );

/**  Dev Atlantaboatshow emailaddress sso   */
$metadata['http://www.okta.com/exk1icy4vdm4tABQN0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1icy4vdm4tABQN0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_devatlantahttpsemailaddressdevatlsso_1/exk1icy4vdm4tABQN0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_devatlantahttpsemailaddressdevatlsso_1/exk1icy4vdm4tABQN0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/**  Dev Chicagoboatshow emailaddress sso   */
$metadata['http://www.okta.com/exk1iojw727CSlSg10h8'] = array (
  'entityid' => 'http://www.okta.com/exk1iojw727CSlSg10h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_devchicagohttpsemailaddressdevchisso_1/exk1iojw727CSlSg10h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_devchicagohttpsemailaddressdevchisso_1/exk1iojw727CSlSg10h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);


/* Stage Atlantaboatshow emailaddress sso  */
$metadata['http://www.okta.com/exk1ioq7xivS9OtcR0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1ioq7xivS9OtcR0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_stageatlantaboatshowemailaddresssso_1/exk1ioq7xivS9OtcR0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_stageatlantaboatshowemailaddresssso_1/exk1ioq7xivS9OtcR0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Stage Chicagoboatshow emailaddress sso  */
$metadata['http://www.okta.com/exk1iorgg6ixa2IAS0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1iorgg6ixa2IAS0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_stagechicagoboatshowemailaddresssso_1/exk1iorgg6ixa2IAS0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_stagechicagoboatshowemailaddresssso_1/exk1iorgg6ixa2IAS0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod Atlantaboatshow emailaddress sso  */
$metadata['http://www.okta.com/exk1iyxsrnkFKZWDK0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1iyxsrnkFKZWDK0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionatlantaboatshowemailaddresssso_1/exk1iyxsrnkFKZWDK0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionatlantaboatshowemailaddresssso_1/exk1iyxsrnkFKZWDK0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod atlanticcity emailaddress sso  */
$metadata['http://www.okta.com/exk1j69n78bjlEtEu0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j69n78bjlEtEu0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionatlanticcityboatshowemailaddresssso_1/exk1j69n78bjlEtEu0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionatlanticcityboatshowemailaddresssso_1/exk1j69n78bjlEtEu0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);
/* Prod baltimore emailaddress sso  */
$metadata['http://www.okta.com/exk1j69pecopUNcbo0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j69pecopUNcbo0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionbaltimoreboatshowemailaddresssso_1/exk1j69pecopUNcbo0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionbaltimoreboatshowemailaddresssso_1/exk1j69pecopUNcbo0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);
/* Prod Chicagoboatshow emailaddress sso  */
$metadata['http://www.okta.com/exk1izxfjgive944K0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1izxfjgive944K0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionchicagoboatshowemailaddresssso_1/exk1izxfjgive944K0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionchicagoboatshowemailaddresssso_1/exk1izxfjgive944K0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
    1 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod chicagoland emailaddress sso  */
$metadata['http://www.okta.com/exk1j6gkkf8uGufO80h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6gkkf8uGufO80h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionchicagolandsportshowemailaddresssso_1/exk1j6gkkf8uGufO80h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionchicagolandsportshowemailaddresssso_1/exk1j6gkkf8uGufO80h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod kansascity emailaddress sso  */
$metadata['http://www.okta.com/exk1j6egyj999g3cH0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6egyj999g3cH0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionkansascityboatshowemailaddresssso_1/exk1j6egyj999g3cH0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionkansascityboatshowemailaddresssso_1/exk1j6egyj999g3cH0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod louisville emailaddress sso  */
$metadata['http://www.okta.com/exk1j6eimhwhREwbA0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6eimhwhREwbA0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionlouisvilleboatshowemailaddresssso_1/exk1j6eimhwhREwbA0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionlouisvilleboatshowemailaddresssso_1/exk1j6eimhwhREwbA0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod miami emailaddress sso  */
$metadata['http://www.okta.com/exk1j6ge1z6m3HiyC0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6ge1z6m3HiyC0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionmiamiboatshowemailaddresssso_1/exk1j6ge1z6m3HiyC0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionmiamiboatshowemailaddresssso_1/exk1j6ge1z6m3HiyC0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod minneapolis emailaddress sso  */
$metadata['http://www.okta.com/exk1j6gfsce76yZ9N0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6gfsce76yZ9N0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionminneapolisboatshowemailaddresssso_1/exk1j6gfsce76yZ9N0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionminneapolisboatshowemailaddresssso_1/exk1j6gfsce76yZ9N0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod nashville emailaddress sso  */
$metadata['http://www.okta.com/exk1j6gfees6xiW6d0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6gfees6xiW6d0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionnashvilleboatshowemailaddresssso_1/exk1j6gfees6xiW6d0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionnashvilleboatshowemailaddresssso_1/exk1j6gfees6xiW6d0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod newengland emailaddress sso  */
$metadata['http://www.okta.com/exk1j6gfdsuyQuoer0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6gfdsuyQuoer0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionnewenglandboatshowemailaddresssso_1/exk1j6gfdsuyQuoer0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionnewenglandboatshowemailaddresssso_1/exk1j6gfdsuyQuoer0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod newyork emailaddress sso  */
$metadata['http://www.okta.com/exk1j6ggn621twJd90h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6ggn621twJd90h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionnyboatshowemailaddresssso_1/exk1j6ggn621twJd90h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionnyboatshowemailaddresssso_1/exk1j6ggn621twJd90h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod northwest emailaddress sso  */
$metadata['http://www.okta.com/exk1j6gguxtTnFYqz0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6gguxtTnFYqz0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionnorthwestboatshowemailaddresssso_1/exk1j6gguxtTnFYqz0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionnorthwestboatshowemailaddresssso_1/exk1j6gguxtTnFYqz0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod norwalk emailaddress sso  */
$metadata['http://www.okta.com/exk1j6eca9k6xZ3Y30h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6eca9k6xZ3Y30h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionboatshownorwalkemailaddresssso_1/exk1j6eca9k6xZ3Y30h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionboatshownorwalkemailaddresssso_1/exk1j6eca9k6xZ3Y30h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod saltwater emailaddress sso  */
$metadata['http://www.okta.com/exk1j6gijlmOWyqfV0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6gijlmOWyqfV0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionsaltwatersportshowemailaddresssso_1/exk1j6gijlmOWyqfV0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionsaltwatersportshowemailaddresssso_1/exk1j6gijlmOWyqfV0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod sportshows emailaddress sso  */
$metadata['http://www.okta.com/exk1j6gigv58S0xER0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6gigv58S0xER0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionsportshowemailaddresssso_1/exk1j6gigv58S0xER0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionsportshowemailaddresssso_1/exk1j6gigv58S0xER0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod stlouis emailaddress sso  */
$metadata['http://www.okta.com/exk1j6gkoi4Pp5AZv0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6gkoi4Pp5AZv0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionstlouisboatshowemailaddresssso_1/exk1j6gkoi4Pp5AZv0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionstlouisboatshowemailaddresssso_1/exk1j6gkoi4Pp5AZv0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod suffern emailaddress sso  */
$metadata['http://www.okta.com/exk1j6gkytePfmEdH0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6gkytePfmEdH0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productionsuffernsportshowemailaddresssso_1/exk1j6gkytePfmEdH0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productionsuffernsportshowemailaddresssso_1/exk1j6gkytePfmEdH0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);

/* Prod tampa emailaddress sso  */
$metadata['http://www.okta.com/exk1j6gkstvpxykSW0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1j6gkstvpxykSW0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_productiontampaboatshowemailaddresssso_1/exk1j6gkstvpxykSW0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_productiontampaboatshowemailaddresssso_1/exk1j6gkstvpxykSW0h8/sso/saml',
    ),
  ),
  'SingleLogoutService' =>
  array (
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDmDCCAoCgAwIBAgIGAV2h3gMhMA0GCSqGSIb3DQEBCwUAMIGMMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxDTALBgNVBAMMBG5tbWExHDAaBgkqhkiG9w0BCQEWDWluZm9A
b2t0YS5jb20wHhcNMTcwODAyMDczMzI3WhcNMjcwODAyMDczNDI3WjCBjDELMAkGA1UEBhMCVVMx
EzARBgNVBAgMCkNhbGlmb3JuaWExFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xDTALBgNVBAoMBE9r
dGExFDASBgNVBAsMC1NTT1Byb3ZpZGVyMQ0wCwYDVQQDDARubW1hMRwwGgYJKoZIhvcNAQkBFg1p
bmZvQG9rdGEuY29tMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7js0fHpN2KoCNKJ1
rO3NEGw061einGMDSdKDQI6KaGVyzH1kBElIDSdeleHB8deHtoqAi5yhvy5t1tTB+6B878smtq3p
K/u4mMyNgBlVIpy7FdFmmuxw8iiU+SzMlHY7PjFXqUTfz6vv3/BzxOTffJ9QQzw3fv2oJl0M4j+g
DwUObXRieT4Oi90IlnYTUZRPS9o78WunydbQRrSkePZmRKYWwUO1lWyigHoJcrcRcZudzKVhVvEy
ENEulITGsW9MD3lMxT3H23HYqVgAw0yWvaHz3wbJ7rR6PjZgei+oMg0MzlnryOR42Z+AsBSQNOr5
gqUFTL00Phc61deSfU/HlQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAcQiGmqco2VmIvJIHfrMaQ
ZmJqpFVTrnCKXhAVAjXVyC2ofFWKicH6EqR32Sg8rBr+AiyhX7zU9Ti0L0kxXQ8p6OryTE5j1sdU
q9gjv9Gza0ftQ0OEpImcC5mdyyMFign/kbMs6adSH/zD+e6oaEzMxj5UF+Mzq4sFLI1zFN3SUo5c
PNzSKS2MI9Dnc5bvM8mfWBv0zkl6HgBf6X993gJAfJ28vvJ1Kj79NH5WEnrqLYykc1sPhplyY1/0
OJarLacqJXdi+l//gL/uT/0OA3TA3I4JPV7qbiPQKJuiUXGNNiy0TkZTkLcmZOH/2k/YbIQU0o1K
IGVezl2GnehhLt7m',
    ),
  ),
);
