<?php
/*
 Copyright 2016-present Google Inc. All Rights Reserved.

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 */


/** Uses proselint to lint text */
final class ProseLinter extends ArcanistExternalLinter {

  public function getInfoName() {
    return 'proselint';
  }

  public function getInfoURI() {
    return '';
  }

  public function getInfoDescription() {
    return pht('Use proselint for processing specified files.');
  }

  public function getLinterName() {
    return 'prose';
  }

  public function getLinterConfigurationName() {
    return 'prose';
  }

  public function getDefaultBinary() {
    return 'proselint';
  }

  public function getInstallInstructions() {
    return pht('Install proselint with `pip install proselint`');
  }

  public function shouldExpectCommandErrors() {
    return true;
  }

  protected function getMandatoryFlags() {
    return array(
      '--json'
    );
  }

  protected function getDefaultMessageSeverity($code) {
    return ArcanistLintSeverity::SEVERITY_ADVICE;
  }

  protected function canCustomizeLintSeverities() {
    return true;
  }

  protected function parseLinterOutput($path, $err, $stdout, $stderr) {
    $ok = ($err == 0 || $err == 1); // proselint returns 1 if linter warnings were detected.

    if (!$ok) {
      return false;
    }

    $results = json_decode($stdout, TRUE);
    $errors = (array)$results['data']['errors'];

    if (empty($errors)) {
      return array();
    }

    $messages = array();
    foreach ($errors as $error) {
      $message = id(new ArcanistLintMessage())
        ->setPath($path)
        ->setLine($error['line'])
        ->setChar($error['column'])
        ->setCode($error['check'])
        ->setSeverity($this->getLintMessageSeverity($error['check']))
        ->setName('proselint violoation')
        ->setDescription($error['message']);
      $messages []= $message;
    }
    
    return $messages;
  }
}
