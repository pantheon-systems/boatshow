<?php
/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */

/**   Dev Chicagoboatshow Https Transient **/
 $metadata['http://www.okta.com/exk1i54wg3b6zknNl0h8'] = array (
   'entityid' => 'http://www.okta.com/exk1i54wg3b6zknNl0h8',
   'contacts' =>
   array (
   ),
   'metadata-set' => 'saml20-idp-remote',
   'SingleSignOnService' =>
   array (
     0 =>
     array (
       'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
       'Location' => 'https://nmma.okta.com/app/nmma_devchicagoboatshowhttpstransient_1/exk1i54wg3b6zknNl0h8/sso/saml',
     ),
     1 =>
     array (
       'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
       'Location' => 'https://nmma.okta.com/app/nmma_devchicagoboatshowhttpstransient_1/exk1i54wg3b6zknNl0h8/sso/saml',
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
     1 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
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

 $metadata['http://www.okta.com/exk1i5506m4s9fdMi0h8'] = array (
  'entityid' => 'http://www.okta.com/exk1i5506m4s9fdMi0h8',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://nmma.okta.com/app/nmma_prodchicagoboatshowhttpstransient_1/exk1i5506m4s9fdMi0h8/sso/saml',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://nmma.okta.com/app/nmma_prodchicagoboatshowhttpstransient_1/exk1i5506m4s9fdMi0h8/sso/saml',
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
    1 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
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
