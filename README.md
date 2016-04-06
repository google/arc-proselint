# prose-lint for arc

prose-lint is a lint engine for use with [Phabricator](phabricator.org)'s `arc` command line tool.
It uses the open source [proselint](http://proselint.com/) tool.

## Features

prose-lint generates advice messages.

Example output:

    Advice  (misc.annotations) proselint violoation
    Annotation left in text.
    
              91 
              92 
    >>>       93 TODO(featherless): Some todo left in text.
              94 
              95 
              
    Advice  (garner.phrasal_adjectives.ly) proselint violoation
    No hyphen is necessary in phrasal adjectives with an adverb ending in -ly.
    
              31 
              32 
              33 
    >>>       34 > This thing should be globally-unique.
              35 
              36 
              37 

## Installation

### Install proselint

    pip install proselint

Read the [proselint installation guide](https://github.com/amperser/proselint#installation) for more
details.

### Project-specific

Add this repository as a git submodule.

    git submodule init
    git submodule add <url for this repo>

Your `.arcconfig` should list `arc-proselint` in the `load` configuration:

    {
      "load": [
        "path/to/arc-proselint"
      ]
    }

### Global

Clone this repository to the same directory where `arcanist` and `libphutil` are globally located.
Your directory structure will look like so:

    arcanist/
    libphutil/
    arc-proselint/

Your `.arcconfig` should list `arc-proselint` in the `load` configuration (without a path):

    {
      "load": [
        "arc-proselint"
      ]
    }

## Usage

Create a `.arclint` file in the root of your project and add the following content:

    {
      "prose": {
        "type": "prose",
        "include": "(\\.(md)$)"
      },
    }

Feel free to change the include/exclude regexes to suit your project's needs.

### Configuration options

Checks can be ignored by configuring their severity:

    {
      "prose": {
        "type": "prose",
        "include": "(\\.(md)$)",
        "severity": {
          "typography.symbols.curly_quotes": "disabled",
          "typography.symbols.ellipsis": "disabled",
          "leonard.exclamation.30ppm": "disabled"
        }
      },
    }

## License

Licensed under the Apache 2.0 license. See LICENSE for details.
