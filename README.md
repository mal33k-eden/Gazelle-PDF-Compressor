#GPDFC - Gazelle PDF Compressor
Ghostscript php wrapper purposely to reduce PDF files.

#Story
GPDFC solely implements the full power of the ghost-script's shrinking (reduce filesize) capability.

I built this simple library, because I didn't get any suitable project to accomplish my PDF file reduction tasks i also got some inspiration from
Alfred Klomp from www.alfredklomp.com.
This library feeds a PDF through Ghostscript, which performs lossy recompression by such methods as downsampling the images to 150dpi. This configuration results in a better quality buy yet a much smaller file.

#Features
<ul>
<li> Shrink remote or local pdf files</li>
<li> Works on windows and unix based systems</li>
<li> More features to come</li>
</ul>

#Requirement
<ul>
<li>For GPDFC to work, the ghostscript command (v9.5.2) must be installed and working in the environment (development machine or server) you are using this library in.
    Check the links section for more help on downloads and installation of ghostscript. </li>
<li>PHP ^v7.4 </li>
</ul>

#Installation 
You can use composer

`composer require mal33k-eden/gazelle-pdf-compressor
`

#Links 
<ul>
<li>https://www.ghostscript.com/download/gsdnld.html</li>
<li>https://www.ghostscript.com/doc/9.52/Install.htm#Overview</li>
</ul>

#Usage 
**Compress**

         use  EmmKwami\GPDFC\GPDFC;
         
         * GPDFC constructor.
         * @param $inputPath  //must be a pdf file
         * @param $outputFile //name of the output pdf file after compression
         * @param $fileLocation  // (optional) either local or foreign - default = local
         * @param $environment // (optional)either uinx or windows - default = unix
         
         //instantiate GPDFC
         $GPDFC = new GPDFC('input.pdf','output.pdf');
         //Compress PDF
         $result = $GPDFC->compress());
         
     */
`


