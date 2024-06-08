<?php include '../common/header.php'; ?>
<h1 class="mb-2 mt-[30px] text-[35px] font-bold bg-gradient-to-bl from-green-400 to-blue-500 inline-block text-transparent bg-clip-text">Validateur XSD</h1>
<form id="validator-form" class="flex w-full h-[60%] mb-[20px] gap-[20px] justify-center flex-wrap">
  <div class="flex flex-col items-start gap-2 basis-[45%]">
    <textarea class="w-full bg-[#F3F3F3] resize-none h-[90%] rounded-md focus:outline-none p-3 caret-green-400" placeholder="Entrer XML ici ..." name="xml" id="xml"></textarea>
    <small class="text-[12px] text-red-600" id="xml-error"></small>
    <button class="bg-gradient-to-bl from-green-400 to-blue-500 rounded-md px-3 py-[5px] text-white uppercase">Valider</button>
  </div>
  <textarea class="bg-[#F3F3F3] resize-none basis-[45%] rounded-md p-3 max-w-[45%] max-h-[100%] focus:outline-none p-3 caret-green-400" placeholder="Entrer Validation XSD ici ..." name="validation" id="validation"></textarea>
</form>
<div id="alert-container" class="flex items-center p-4 mb-4 text-sm border rounded-lg  max-w-[80%] hidden" role="alert">
  <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
  </svg>
  <span class="sr-only">Info</span>
  <div id="alert-text">
    Text
  </div>
</div>
<script src="../../scripts/validator.js"></script>
<?php include '../common/footer.php'; ?>