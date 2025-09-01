<div id="projectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h3 class="text-lg font-bold mb-4">Add Project</h3>
        <input type="text" id="projectName" name="name" class="w-full border rounded p-2 mb-3" placeholder="Project Name">
        <input type="text" id="projectLocation" name="location" class="w-full border rounded p-2 mb-3" placeholder="Project Location">
        <button onclick="saveProject()" class="bg-blue-500 text-white px-3 py-1 rounded">Save</button>
        <button onclick="closeModal('projectModal')" class="ml-2 bg-gray-400 text-white px-3 py-1 rounded">Cancel</button>
    </div>
</div>

<!-- Modals for Add New -->
<div id="phaseModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h3 class="text-lg font-bold mb-4">Add Phase</h3>
        <label for="phaseName" class="block mb-2">Phase Name</label>
        <input type="text" id="phaseName" class="w-full border rounded p-2 mb-3" placeholder="Phase Name">
        <button onclick="savePhase()" class="bg-blue-500 text-white px-3 py-1 rounded">Save</button>
        <button onclick="closeModal('phaseModal')" class="ml-2 bg-gray-400 text-white px-3 py-1 rounded">Cancel</button>
    </div>
</div>

<!-- Modals for Add New -->
<div id="sectorModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h3 class="text-lg font-bold mb-4">Add Sector</h3>
        <label for="sectorName" class="block mb-2">Sector Name</label>
        <input type="text" id="sectorName" class="w-full border rounded p-2 mb-3" placeholder="Sector Name">
        <button onclick="saveSector()" class="bg-blue-500 text-white px-3 py-1 rounded">Save</button>
        <button onclick="closeModal('sectorModal')" class="ml-2 bg-gray-400 text-white px-3 py-1 rounded">Cancel</button>
    </div>
</div>

<!-- Modals for Add New -->
<div id="streetModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h3 class="text-lg font-bold mb-4">Add Street</h3>
        <label for="streetName" class="block mb-2">Street Name</label>
        <input type="text" id="streetName" class="w-full border rounded p-2 mb-3" placeholder="Street Name">
        <button onclick="saveStreet()" class="bg-blue-500 text-white px-3 py-1 rounded">Save</button>
        <button onclick="closeModal('streetModal')" class="ml-2 bg-gray-400 text-white px-3 py-1 rounded">Cancel</button>
    </div>
</div>