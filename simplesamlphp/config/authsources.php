<?php

$config = [

    // This is a authentication source which handles admin authentication.
    'admin' => [
        // The default is to use core:AdminPassword, but it can be replaced with
        // any authentication source.

        'core:AdminPassword',
    ],


    // An authentication source which can authenticate against both SAML 2.0
    // and Shibboleth 1.3 IdPs.
    'default-sp' => [
        'saml:SP',

        // The entity ID of this SP.
        // Can be NULL/unset, in which case an entity ID is generated based on the metadata URL.
        'entityID' => null,

        // The entity ID of the IdP this SP should contact.
        // Can be NULL/unset, in which case the user will be shown a list of available IdPs.
        'idp' => null,

        // The URL to the discovery service.
        // Can be NULL/unset, in which case a builtin discovery service will be used.
        'discoURL' => null,

        /*
         * The attributes parameter must contain an array of desired attributes by the SP.
         * The attributes can be expressed as an array of names or as an associative array
         * in the form of 'friendlyName' => 'name'. This feature requires 'name' to be set.
         * The metadata will then be created as follows:
         * <md:RequestedAttribute FriendlyName="friendlyName" Name="name" />
         */
        /*
        'name' => [
            'en' => 'A service',
            'no' => 'En tjeneste',
        ],

        'attributes' => [
            'attrname' => 'urn:oid:x.x.x.x',
        ],
        'attributes.required' => [
            'urn:oid:x.x.x.x',
        ],
        */
    ],
/* Dev Atlantaboatshow emailaddress sso  */
            'dev-atl-sso-sp' => [
                'saml:SP',
                'entityID' => 'dev-atl-emailaddress-sso',
                'certificate' => '../cert/dev2.atlantaboatshow.saml.crt',
                'privatekey' => '../cert/dev2.atlantaboatshow.saml.pem',
                'redirect.sign' => TRUE,
                'redirect.validate' => TRUE,
                'idp' => 'http://www.okta.com/exk1icy4vdm4tABQN0h8',
                //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
                //'idp' => null,
              ],

/* Dev Chicagoboatshow emailaddress sso  */
      'dev-chi-sso-sp' => [
          'saml:SP',
          'entityID' => 'dev-chi-emailaddress-sso',
          'certificate' => '../cert/dev2.chicagoboatshow.saml.crt',
          'privatekey' => '../cert/dev2.chicagoboatshow.saml.pem',
          'redirect.sign' => TRUE,
          'redirect.validate' => TRUE,
          'idp' => 'http://www.okta.com/exk1iojw727CSlSg10h8',
          //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
          //'idp' => null,
        ],

/* Stage Atlantaboatshow emailaddress sso  */
            'stage-atl-sso-sp' => [
                'saml:SP',
                'entityID' => 'stage-atl-emailaddress-sso',
                'certificate' => '../cert/stage2.atlantaboatshow.saml.crt',
                'privatekey' => '../cert/stage2.atlantaboatshow.saml.pem',
                'redirect.sign' => TRUE,
                'redirect.validate' => TRUE,
                'idp' => 'http://www.okta.com/exk1ioq7xivS9OtcR0h8',
                //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
                //'idp' => null,
              ],

/* Stage Chicagoboatshow emailaddress sso  */
      'stage-chi-sso-sp' => [
          'saml:SP',
          'entityID' => 'stage-chi-emailaddress-sso',
          'certificate' => '../cert/stage2.chicagoboatshow.saml.crt',
          'privatekey' => '../cert/stage2.chicagoboatshow.saml.pem',
          'redirect.sign' => TRUE,
          'redirect.validate' => TRUE,
          'idp' => 'http://www.okta.com/exk1iorgg6ixa2IAS0h8',
          //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
          //'idp' => null,
        ],

/* Prod Atlantaboatshow emailaddress sso  */
      'prod-atl-sso-sp' => [
          'saml:SP',
          'entityID' => 'prod-atl-emailaddress-sso',
          'certificate' => '../cert/www.atlantaboatshow.saml.crt',
          'privatekey' => '../cert/www.atlantaboatshow.saml.pem',
          'redirect.sign' => TRUE,
          'redirect.validate' => TRUE,
          'idp' => 'http://www.okta.com/exk1iyxsrnkFKZWDK0h8',
          //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
          //'idp' => null,
        ],
/* Prod atlanticcity emailaddress sso  */
'prod-ac-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-ac-emailaddress-sso',
    'certificate' => '../cert/www.acboatshow.saml.crt',
    'privatekey' => '../cert/www.acboatshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j69n78bjlEtEu0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod baltimore emailaddress sso  */
'prod-bal-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-bal-emailaddress-sso',
    'certificate' => '../cert/www.baltimoreboatshow.saml.crt',
    'privatekey' => '../cert/www.baltimoreboatshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j69pecopUNcbo0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod Chicagoboatshow emailaddress sso  */
      'prod-chi-sso-sp' => [
          'saml:SP',
          'entityID' => 'prod-chi-emailaddress-sso',
          'certificate' => '../cert/www.chicagoboatshow.saml.crt',
          'privatekey' => '../cert/www.chicagoboatshow.saml.pem',
          'redirect.sign' => TRUE,
          'redirect.validate' => TRUE,
          'idp' => 'http://www.okta.com/exk1izxfjgive944K0h8',
          //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
          //'idp' => null,
        ],
/* Prod chicagoland emailaddress sso  */
'prod-chilnd-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-chilnd-emailaddress-sso',
    'certificate' => '../cert/chicagoland.sportshows.saml.crt',
    'privatekey' => '../cert/chicagoland.sportshows.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6gkkf8uGufO80h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod kansascity emailaddress sso  */
'prod-kc-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-kc-emailaddress-sso',
    'certificate' => '../cert/www.kansascitysportshow.saml.crt',
    'privatekey' => '../cert/www.kansascitysportshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6egyj999g3cH0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod louisville emailaddress sso  */
'prod-lvl-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-lvl-emailaddress-sso',
    'certificate' => '../cert/www.louisvilleboatshow.saml.crt',
    'privatekey' => '../cert/www.louisvilleboatshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6eimhwhREwbA0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod miami emailaddress sso  */
'prod-mia-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-mia-emailaddress-sso',
    'certificate' => '../cert/www.miamiboatshow.saml.crt',
    'privatekey' => '../cert/www.miamiboatshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6ge1z6m3HiyC0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod minneapolis emailaddress sso  */
'prod-min-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-min-emailaddress-sso',
    'certificate' => '../cert/www.minneapolisboatshow.saml.crt',
    'privatekey' => '../cert/www.minneapolisboatshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6gfsce76yZ9N0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod nashville emailaddress sso  */
'prod-nsh-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-nsh-emailaddress-sso',
    'certificate' => '../cert/www.nashvilleboatshow.saml.crt',
    'privatekey' => '../cert/www.nashvilleboatshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6gfees6xiW6d0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod newengland emailaddress sso  */
'prod-ne-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-ne-emailaddress-sso',
    'certificate' => '../cert/www.newenglandboatshow.saml.crt',
    'privatekey' => '../cert/www.newenglandboatshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6gfdsuyQuoer0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod newyork emailaddress sso  */
'prod-ny-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-ny-emailaddress-sso',
    'certificate' => '../cert/www.nyboatshow.saml.crt',
    'privatekey' => '../cert/www.nyboatshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6ggn621twJd90h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod northwest emailaddress sso  */
'prod-nw-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-nw-emailaddress-sso',
    'certificate' => '../cert/www.northwestsportshow.saml.crt',
    'privatekey' => '../cert/www.northwestsportshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6gguxtTnFYqz0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod norwalk emailaddress sso  */
'prod-nor-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-nor-emailaddress-sso',
    'certificate' => '../cert/www.boatshownorwalk.saml.crt',
    'privatekey' => '../cert/www.boatshownorwalk.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6eca9k6xZ3Y30h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod saltwater emailaddress sso  */
'prod-sw-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-sw-emailaddress-sso',
    'certificate' => '../cert/saltwater.sportshows.saml.crt',
    'privatekey' => '../cert/saltwater.sportshows.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6gijlmOWyqfV0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod sportshows emailaddress sso  */
'prod-ss-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-ss-emailaddress-sso',
    'certificate' => '../cert/www.sportshows.saml.crt',
    'privatekey' => '../cert/www.sportshows.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6gigv58S0xER0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod stlouis emailaddress sso  */
'prod-stl-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-stl-emailaddress-sso',
    'certificate' => '../cert/www.stlouisboatshow.saml.crt',
    'privatekey' => '../cert/www.stlouisboatshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6gkoi4Pp5AZv0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod suffern emailaddress sso  */
'prod-sfn-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-sfn-emailaddress-sso',
    'certificate' => '../cert/suffern.sportshows.saml.crt',
    'privatekey' => '../cert/suffern.sportshows.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6gkytePfmEdH0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],
/* Prod tampa emailaddress sso  */
'prod-tmp-sso-sp' => [
    'saml:SP',
    'entityID' => 'prod-tmp-emailaddress-sso',
    'certificate' => '../cert/www.tampaboatshow.saml.crt',
    'privatekey' => '../cert/www.tampaboatshow.saml.pem',
    'redirect.sign' => TRUE,
    'redirect.validate' => TRUE,
    'idp' => 'http://www.okta.com/exk1j6gkstvpxykSW0h8',
    //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    //'idp' => null,
  ],












    /*
    'example-sql' => [
        'sqlauth:SQL',
        'dsn' => 'pgsql:host=sql.example.org;port=5432;dbname=simplesaml',
        'username' => 'simplesaml',
        'password' => 'secretpassword',
        'query' => 'SELECT uid, givenName, email, eduPersonPrincipalName FROM users WHERE uid = :username ' .
            'AND password = SHA2(CONCAT((SELECT salt FROM users WHERE uid = :username), :password), 256);',
    ],
    */

    /*
    'example-static' => [
        'exampleauth:StaticSource',
        'uid' => ['testuser'],
        'eduPersonAffiliation' => ['member', 'employee'],
        'cn' => ['Test User'],
    ],
    */

    /*
    'example-userpass' => [
        'exampleauth:UserPass',

        // Give the user an option to save their username for future login attempts
        // And when enabled, what should the default be, to save the username or not
        //'remember.username.enabled' => false,
        //'remember.username.checked' => false,

        'student:studentpass' => [
            'uid' => ['test'],
            'eduPersonAffiliation' => ['member', 'student'],
        ],
        'employee:employeepass' => [
            'uid' => ['employee'],
            'eduPersonAffiliation' => ['member', 'employee'],
        ],
    ],
    */

    /*
    'crypto-hash' => [
        'authcrypt:Hash',
        // hashed version of 'verysecret', made with bin/pwgen.php
        'professor:{SSHA256}P6FDTEEIY2EnER9a6P2GwHhI5JDrwBgjQ913oVQjBngmCtrNBUMowA==' => [
            'uid' => ['prof_a'],
            'eduPersonAffiliation' => ['member', 'employee', 'board'],
        ],
    ],
    */

    /*
    'htpasswd' => [
        'authcrypt:Htpasswd',
        'htpasswd_file' => '/var/www/foo.edu/legacy_app/.htpasswd',
        'static_attributes' => [
            'eduPersonAffiliation' => ['member', 'employee'],
            'Organization' => ['University of Foo'],
        ],
    ],
    */

    /*
    // This authentication source serves as an example of integration with an
    // external authentication engine. Take a look at the comment in the beginning
    // of modules/exampleauth/lib/Auth/Source/External.php for a description of
    // how to adjust it to your own site.
    'example-external' => [
        'exampleauth:External',
    ],
    */

    /*
    'yubikey' => [
        'authYubiKey:YubiKey',
         'id' => '000',
        // 'key' => '012345678',
    ],
    */

    /*
    'facebook' => [
        'authfacebook:Facebook',
        // Register your Facebook application on http://www.facebook.com/developers
        // App ID or API key (requests with App ID should be faster; https://github.com/facebook/php-sdk/issues/214)
        'api_key' => 'xxxxxxxxxxxxxxxx',
        // App Secret
        'secret' => 'xxxxxxxxxxxxxxxx',
        // which additional data permissions to request from user
        // see http://developers.facebook.com/docs/authentication/permissions/ for the full list
        // 'req_perms' => 'email,user_birthday',
        // Which additional user profile fields to request.
        // When empty, only the app-specific user id and name will be returned
        // See https://developers.facebook.com/docs/graph-api/reference/v2.6/user for the full list
        // 'user_fields' => 'email,birthday,third_party_id,name,first_name,last_name',
    ],
    */

    /*
    // LinkedIn OAuth Authentication API.
    // Register your application to get an API key here:
    //  https://www.linkedin.com/secure/developer
    // Attributes definition:
    //  https://developer.linkedin.com/docs/fields
    'linkedin' => [
        'authlinkedin:LinkedIn',
        'key' => 'xxxxxxxxxxxxxxxx',
        'secret' => 'xxxxxxxxxxxxxxxx',
        'attributes' => 'id,first-name,last-name,headline,summary,specialties,picture-url,email-address',
    ],
    */

    /*
    // Microsoft Account (Windows Live ID) Authentication API.
    // Register your application to get an API key here:
    //  https://apps.dev.microsoft.com/
    'windowslive' => [
        'authwindowslive:LiveID',
        'key' => 'xxxxxxxxxxxxxxxx',
        'secret' => 'xxxxxxxxxxxxxxxx',
    ],
    */

    /*
    // Example of a LDAP authentication source.
    'example-ldap' => [
        'ldap:LDAP',

        // Give the user an option to save their username for future login attempts
        // And when enabled, what should the default be, to save the username or not
        //'remember.username.enabled' => false,
        //'remember.username.checked' => false,

        // The hostname of the LDAP server.
        'hostname' => 'ldap.example.org',

        // Whether SSL/TLS should be used when contacting the LDAP server.
        'enable_tls' => true,

        // Whether debug output from the LDAP library should be enabled.
        // Default is FALSE.
        'debug' => false,

        // The timeout for accessing the LDAP server, in seconds.
        // The default is 0, which means no timeout.
        'timeout' => 0,

        // The port used when accessing the LDAP server.
        // The default is 389.
        'port' => 389,

        // Set whether to follow referrals. AD Controllers may require FALSE to function.
        'referrals' => true,

        // Which attributes should be retrieved from the LDAP server.
        // This can be an array of attribute names, or NULL, in which case
        // all attributes are fetched.
        'attributes' => null,

        // The pattern which should be used to create the users DN given the username.
        // %username% in this pattern will be replaced with the users username.
        //
        // This option is not used if the search.enable option is set to TRUE.
        'dnpattern' => 'uid=%username%,ou=people,dc=example,dc=org',

        // As an alternative to specifying a pattern for the users DN, it is possible to
        // search for the username in a set of attributes. This is enabled by this option.
        'search.enable' => false,

        // The DN which will be used as a base for the search.
        // This can be a single string, in which case only that DN is searched, or an
        // array of strings, in which case they will be searched in the order given.
        'search.base' => 'ou=people,dc=example,dc=org',

        // The attribute(s) the username should match against.
        //
        // This is an array with one or more attribute names. Any of the attributes in
        // the array may match the value the username.
        'search.attributes' => ['uid', 'mail'],

        // Additional LDAP filters appended to the search attributes
        //'search.filter' => '(objectclass=inetorgperson)',

        // The username & password the SimpleSAMLphp should bind to before searching. If
        // this is left as NULL, no bind will be performed before searching.
        'search.username' => null,
        'search.password' => null,

        // If the directory uses privilege separation,
        // the authenticated user may not be able to retrieve
        // all required attribures, a privileged entity is required
        // to get them. This is enabled with this option.
        'priv.read' => false,

        // The DN & password the SimpleSAMLphp should bind to before
        // retrieving attributes. These options are required if
        // 'priv.read' is set to TRUE.
        'priv.username' => null,
        'priv.password' => null,

    ],
    */

    /*
    // Example of an LDAPMulti authentication source.
    'example-ldapmulti' => [
        'ldap:LDAPMulti',

        // Give the user an option to save their username for future login attempts
        // And when enabled, what should the default be, to save the username or not
        //'remember.username.enabled' => false,
        //'remember.username.checked' => false,

        // Give the user an option to save their organization choice for future login
        // attempts. And when enabled, what should the default be, checked or not.
        //'remember.organization.enabled' => false,
        //'remember.organization.checked' => false,

        // The way the organization as part of the username should be handled.
        // Three possible values:
        // - 'none':   No handling of the organization. Allows '@' to be part
        //             of the username.
        // - 'allow':  Will allow users to type 'username@organization'.
        // - 'force':  Force users to type 'username@organization'. The dropdown
        //             list will be hidden.
        //
        // The default is 'none'.
        'username_organization_method' => 'none',

        // Whether the organization should be included as part of the username
        // when authenticating. If this is set to TRUE, the username will be on
        // the form <username>@<organization identifier>. If this is FALSE, the
        // username will be used as the user enters it.
        //
        // The default is FALSE.
        'include_organization_in_username' => false,

        // A list of available LDAP servers.
        //
        // The index is an identifier for the organization/group. When
        // 'username_organization_method' is set to something other than 'none',
        // the organization-part of the username is matched against the index.
        //
        // The value of each element is an array in the same format as an LDAP
        // authentication source.
        'employees' => [
            // A short name/description for this group. Will be shown in a dropdown list
            // when the user logs on.
            //
            // This option can be a string or an array with language => text mappings.
            'description' => 'Employees',

            // The rest of the options are the same as those available for
            // the LDAP authentication source.
            'hostname' => 'ldap.employees.example.org',
            'dnpattern' => 'uid=%username%,ou=employees,dc=example,dc=org',
        ],

        'students' => [
            'description' => 'Students',

            'hostname' => 'ldap.students.example.org',
            'dnpattern' => 'uid=%username%,ou=students,dc=example,dc=org',
        ],
    ],
    */
];
