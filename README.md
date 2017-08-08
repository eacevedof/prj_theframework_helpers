

<hr/>

```
sudo npm install -g yarn
```

/usr/local/bin/yarn -> /usr/local/lib/node_modules/yarn/bin/yarn.js
/usr/local/bin/yarnpkg -> /usr/local/lib/node_modules/yarn/bin/yarn.js
/usr/local/lib
└─┬ yarn@0.27.5
  ├─┬ babel-runtime@6.25.0
  │ ├── core-js@2.5.0
  │ └── regenerator-runtime@0.10.5
  ├── bytes@2.5.0
  ├── camelcase@4.1.0
  ├─┬ chalk@1.1.3
  │ ├── ansi-styles@2.2.1
  │ ├── escape-string-regexp@1.0.5
  │ ├─┬ has-ansi@2.0.0
  │ │ └── ansi-regex@2.1.1
  │ ├── strip-ansi@3.0.1
  │ └── supports-color@2.0.0
  ├─┬ cmd-shim@2.0.2
  │ └── graceful-fs@4.1.11
  ├── commander@2.11.0
  ├── death@1.1.0
  ├─┬ debug@2.6.8
  │ └── ms@2.0.0
  ├── detect-indent@5.0.0
  ├─┬ glob@7.1.2
  │ ├── fs.realpath@1.0.0
  │ ├─┬ inflight@1.0.6
  │ │ └── wrappy@1.0.2
  │ ├── inherits@2.0.3
  │ ├─┬ minimatch@3.0.4
  │ │ └─┬ brace-expansion@1.1.8
  │ │   ├── balanced-match@1.0.0
  │ │   └── concat-map@0.0.1
  │ ├── once@1.4.0
  │ └── path-is-absolute@1.0.1
  ├─┬ gunzip-maybe@1.4.1
  │ ├─┬ browserify-zlib@0.1.4
  │ │ └── pako@0.2.9
  │ ├── is-deflate@1.0.0
  │ ├── is-gzip@1.0.0
  │ ├─┬ peek-stream@1.1.2
  │ │ └─┬ duplexify@3.5.1
  │ │   └── stream-shift@1.0.0
  │ ├── pumpify@1.3.5
  │ └── through2@2.0.3
  ├── ini@1.3.4
  ├─┬ inquirer@3.2.1
  │ ├── ansi-escapes@2.0.0
  │ ├─┬ chalk@2.1.0
  │ │ ├─┬ ansi-styles@3.2.0
  │ │ │ └─┬ color-convert@1.9.0
  │ │ │   └── color-name@1.1.3
  │ │ └─┬ supports-color@4.2.1
  │ │   └── has-flag@2.0.0
  │ ├─┬ cli-cursor@2.1.0
  │ │ └─┬ restore-cursor@2.0.0
  │ │   └─┬ onetime@2.0.1
  │ │     └── mimic-fn@1.1.0
  │ ├── cli-width@2.1.0
  │ ├─┬ external-editor@2.0.4
  │ │ ├── iconv-lite@0.4.18
  │ │ ├── jschardet@1.5.1
  │ │ └─┬ tmp@0.0.31
  │ │   └── os-tmpdir@1.0.2
  │ ├── figures@2.0.0
  │ ├── lodash@4.17.4
  │ ├── mute-stream@0.0.7
  │ ├─┬ run-async@2.3.0
  │ │ └── is-promise@2.1.0
  │ ├── rx-lite@4.0.8
  │ ├── rx-lite-aggregates@4.0.8
  │ ├─┬ string-width@2.1.1
  │ │ ├── is-fullwidth-code-point@2.0.0
  │ │ └─┬ strip-ansi@4.0.0
  │ │   └── ansi-regex@3.0.0
  │ ├─┬ strip-ansi@4.0.0
  │ │ └── ansi-regex@3.0.0
  │ └── through@2.3.8
  ├─┬ invariant@2.2.2
  │ └─┬ loose-envify@1.3.1
  │   └── js-tokens@3.0.2
  ├─┬ is-builtin-module@1.0.0
  │ └── builtin-modules@1.1.1
  ├─┬ is-ci@1.0.10
  │ └── ci-info@1.0.0
  ├── leven@2.1.0
  ├─┬ loud-rejection@1.6.0
  │ ├─┬ currently-unhandled@0.4.1
  │ │ └── array-find-index@1.0.2
  │ └── signal-exit@3.0.2
  ├─┬ micromatch@2.3.11
  │ ├─┬ arr-diff@2.0.0
  │ │ └── arr-flatten@1.1.0
  │ ├── array-unique@0.2.1
  │ ├─┬ braces@1.8.5
  │ │ ├─┬ expand-range@1.8.2
  │ │ │ └─┬ fill-range@2.2.3
  │ │ │   ├── is-number@2.1.0
  │ │ │   ├── isobject@2.1.0
  │ │ │   ├─┬ randomatic@1.1.7
  │ │ │   │ ├─┬ is-number@3.0.0
  │ │ │   │ │ └── kind-of@3.2.2
  │ │ │   │ └── kind-of@4.0.0
  │ │ │   └── repeat-string@1.6.1
  │ │ ├── preserve@0.2.0
  │ │ └── repeat-element@1.1.2
  │ ├─┬ expand-brackets@0.1.5
  │ │ └── is-posix-bracket@0.1.1
  │ ├── extglob@0.3.2
  │ ├── filename-regex@2.0.1
  │ ├── is-extglob@1.0.0
  │ ├── is-glob@2.0.1
  │ ├─┬ kind-of@3.2.2
  │ │ └── is-buffer@1.1.5
  │ ├─┬ normalize-path@2.1.1
  │ │ └── remove-trailing-separator@1.0.2
  │ ├─┬ object.omit@2.0.1
  │ │ ├─┬ for-own@0.1.5
  │ │ │ └── for-in@1.0.2
  │ │ └── is-extendable@0.1.1
  │ ├─┬ parse-glob@3.0.4
  │ │ ├─┬ glob-base@0.3.0
  │ │ │ └── glob-parent@2.0.0
  │ │ └── is-dotfile@1.0.3
  │ └─┬ regex-cache@0.4.3
  │   ├── is-equal-shallow@0.1.3
  │   └── is-primitive@2.0.0
  ├─┬ mkdirp@0.5.1
  │ └── minimist@0.0.8
  ├─┬ node-emoji@1.8.1
  │ └── lodash.toarray@4.4.0
  ├── object-path@0.11.4
  ├─┬ proper-lockfile@2.0.1
  │ └── retry@0.10.1
  ├── read@1.0.7
  ├─┬ request@2.81.0
  │ ├── aws-sign2@0.6.0
  │ ├── aws4@1.6.0
  │ ├── caseless@0.12.0
  │ ├─┬ combined-stream@1.0.5
  │ │ └── delayed-stream@1.0.0
  │ ├── extend@3.0.1
  │ ├── forever-agent@0.6.1
  │ ├─┬ form-data@2.1.4
  │ │ └── asynckit@0.4.0
  │ ├─┬ har-validator@4.2.1
  │ │ ├─┬ ajv@4.11.8
  │ │ │ ├── co@4.6.0
  │ │ │ └─┬ json-stable-stringify@1.0.1
  │ │ │   └── jsonify@0.0.0
  │ │ └── har-schema@1.0.5
  │ ├─┬ hawk@3.1.3
  │ │ ├── boom@2.10.1
  │ │ ├── cryptiles@2.0.5
  │ │ ├── hoek@2.16.3
  │ │ └── sntp@1.0.9
  │ ├─┬ http-signature@1.1.1
  │ │ ├── assert-plus@0.2.0
  │ │ ├─┬ jsprim@1.4.1
  │ │ │ ├── assert-plus@1.0.0
  │ │ │ ├── extsprintf@1.3.0
  │ │ │ ├── json-schema@0.2.3
  │ │ │ └─┬ verror@1.10.0
  │ │ │   └── assert-plus@1.0.0
  │ │ └─┬ sshpk@1.13.1
  │ │   ├── asn1@0.2.3
  │ │   ├── assert-plus@1.0.0
  │ │   ├── bcrypt-pbkdf@1.0.1
  │ │   ├─┬ dashdash@1.14.1
  │ │   │ └── assert-plus@1.0.0
  │ │   ├── ecc-jsbn@0.1.1
  │ │   ├─┬ getpass@0.1.7
  │ │   │ └── assert-plus@1.0.0
  │ │   ├── jsbn@0.1.1
  │ │   └── tweetnacl@0.14.5
  │ ├── is-typedarray@1.0.0
  │ ├── isstream@0.1.2
  │ ├── json-stringify-safe@5.0.1
  │ ├─┬ mime-types@2.1.16
  │ │ └── mime-db@1.29.0
  │ ├── oauth-sign@0.8.2
  │ ├── performance-now@0.2.0
  │ ├── qs@6.4.0
  │ ├── safe-buffer@5.1.1
  │ ├── stringstream@0.0.5
  │ ├─┬ tough-cookie@2.3.2
  │ │ └── punycode@1.4.1
  │ └── tunnel-agent@0.6.0
  ├── request-capture-har@1.2.2
  ├── rimraf@2.6.1
  ├── semver@5.4.1
  ├── strip-bom@3.0.0
  ├─┬ tar-fs@1.15.3
  │ ├── chownr@1.0.1
  │ └── pump@1.0.2
  ├─┬ tar-stream@1.5.4
  │ ├── bl@1.2.1
  │ ├── end-of-stream@1.4.0
  │ ├─┬ readable-stream@2.3.3
  │ │ ├── core-util-is@1.0.2
  │ │ ├── isarray@1.0.0
  │ │ ├── process-nextick-args@1.0.7
  │ │ ├── string_decoder@1.0.3
  │ │ └── util-deprecate@1.0.2
  │ └── xtend@4.0.1
  ├── uuid@3.1.0
  ├── v8-compile-cache@1.1.0
  └─┬ validate-npm-package-license@3.0.1
    ├─┬ spdx-correct@1.0.2
    │ └── spdx-license-ids@1.2.2
    └── spdx-expression-parse@1.0.4

    <hr/>

    ```
    yarn init
    ```
    yarn init v0.27.5
    question name (prj_theframework_helpers):
    question version (1.0.0): site_2.0.0
    question description: site of helpers.theframework.es in react
    question entry point (index.js):
    question repository url (https://github.com/eacevedof/prj_theframework_helpers.git): https://github.com/eacevedof/prj_theframework_helpers/tree/site_2.0.0
    question author (eduardoaf.com <eacevedof@yahoo.es>):
    question license (MIT):
    success Saved package.json
    Done in 110.06s.
