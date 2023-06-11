<?php

namespace my\php\v8;

/**
 * @see http://pecl.php.net/package/ffi
 *
 * this extension is primarily designed for rapid PHP extension prototyping
 *
 * FFI is to allow any given programming language the ability to incorporate code and function calls from external libraries written in other languages.
 *
 * The FFI extension needs to first open the given C library and then parse and pseudo-compile a FFI instance before execution.
 * The FFI extension then acts as a bridge between the C-library code and the PHP script.
 *
 * - Do not use FFI for speed
 *
 * ## 关于扩展
 * php 扩展
 * PHP extensions, as the title implies, extend the PHP language.
 * Each extension can add object-oriented programming (OOP) classes as well as procedural-level functions.
 *
 * 每个扩展有其不同的逻辑目的
 * As an analogy, consider a hospital. In the hospital, you have departments such as Emergency, Surgery, Pediatrics, Orthopedics, Cardiac, X-Ray, and so forth
 * 类比医院的不同科室的存在
 *  Each department is self-contained and serves a distinct purpose. Collectively the departments form the hospital.
 *
 * php就像医院 扩展就像不同的科室
 *
 * core-ext 核心扩展总是可用 伴随php而来 https://github.com/php/php-src/tree/master/ext
 * 其他扩展有的需要 下载-编译-手动开启
 * 非核心扩展如果使用的足够广泛 可能提升为核心扩展
 * Once a non-core extension starts getting used more and more frequently, it's quite possible that it will eventually be migrated into the core
 * 如 ： JSON extension
 *
 * 核心扩展也可能被移除： mcrypt
 *
 * 哪里去找非核心扩展： http://pecl.php.net/ 或者vendor的官网 比如mongodb
 *

 */

/**
 * https://www.php.net/manual/en/class.ffi.php

The FFI class consists of 20 methods that fall into four broad categories, outlined as follows:

• Creational: Methods in this category create instances of classes available from the FFI extension application programming interface (API).
• Comparison: Comparison methods are designed to compare C data values.
• Informational: This set of methods gives you metadata on C data values, including
size and alignment.
• Infrastructural: Infrastructural methods are used to carry out logistical operations
such as copying, populating, and releasing memory.
 */
class FFIDemo
{

}
