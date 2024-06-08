<?php include '../common/header.php'; ?>
<h1 class="mb-2 text-[35px] font-bold bg-gradient-to-bl from-green-400 to-blue-500 inline-block text-transparent bg-clip-text">XML Formatter</h1>
<div class="flex w-full h-[60%] gap-[20px] justify-center flex-wrap">
  <form class="flex flex-col items-start gap-2 basis-[45%]" id="formatter-form">
    <textarea name="xml" id="xml" class="w-full bg-[#F3F3F3] resize-none h-[90%] rounded-md focus:outline-none p-3" placeholder="Entrer XML ici ..."></textarea>
    <small class="text-[12px] text-red-600" id="xml-error"></small>
    <button class="bg-gradient-to-bl from-green-400 to-blue-500 rounded-md px-3 py-[5px] text-white uppercase">Format</button>
  </form>
  <div class="bg-[#030303] basis-[45%] rounded-md p-3 text-green-400 relative max-w-[45%] max-h-[100%]">
    <button class="bg-gradient-to-bl from-green-400 to-blue-500 rounded-md px-3 py-[5px] text-white uppercase absolute top-[10px] right-[10px] hidden" id="copy-button">Copier</button>
    <pre class="overflow-auto w-full h-full" id="formatted-xml">
    </pre>
  </div>
</div>
<script src="../../scripts/formatter.js"></script>
<?php include '../common/footer.php'; ?>