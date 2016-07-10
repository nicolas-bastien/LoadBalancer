LoadBalancer
============

[![Build Status](https://travis-ci.org/nicolas-bastien/LoadBalancer.svg?branch=master)](https://travis-ci.org/nicolas-bastien/LoadBalancer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nicolas-bastien/LoadBalancer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nicolas-bastien/LoadBalancer/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/de3f05b4-3a03-447f-96bd-158c1b66e494/mini.png)](https://insight.sensiolabs.com/projects/de3f05b4-3a03-447f-96bd-158c1b66e494)
[![Latest Stable Version](https://poser.pugx.org/nbn/loadbalancer/v/stable)](https://packagist.org/packages/nbn/loadbalancer)
[![Total Downloads](https://poser.pugx.org/nbn/loadbalancer/downloads.png)](https://packagist.org/packages/nbn/loadbalancer)

## Overview

**Important** : This is a training projet, it's only purpose is to demonstrated how to develop an open source component.


## Installation

This is installable via [Composer](https://getcomposer.org/) as [nbn/loadbalancer](https://packagist.org/packages/nbn/loadbalancer):

    composer require nbn/loadbalancer

## Getting start


This component provides you a loadbalancer class to handle your request.

You have the possibility to define a list of registered host and a chooser algorithm.

This component implement two chooser :

- RotationChooser : basic random chooser
- LoadLimitChosser : return host under a given load limit

## Go further

This component provided all the necessary set of interfaces to extends it as needed.


## Contributing

Pull requests are welcome.

Thanks to
[everyone who has contributed](https://github.com/nicolas-bastien/LoadBalancer/graphs/contributors) already.

---

*Developed by [Nicolas Bastien](https://github.com/nicolas-bastien)*

Released under the MIT License
