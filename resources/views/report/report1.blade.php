<html>
<head>
    <title>
        Reports
    </title>
</head>
<body>

<h1>Report number 1</h1>
<div>
    <ul>
        <x-sidebar title="tttttttttttttitle"  :magicValue="$magicValue" />

        <x-sidebar title='anotherTitle' :magicValue="$magicValue">
            <div>
                divv
            </div>

        </x-sidebar>

        <x-report.subview/>

        <x-navigation>nav</x-navigation>
    </ul>
</div>
</body>
</html>
