@extends('master')
@section('admin')
<h2>Total Departments : {{$data['departmentsCount']}}</h2>
<h2>Total Employee  : {{$data['employeesCount']}}</h2>
<h2>{{$data['performanceBonusesCount']}}</h2>
<h2>{{$data['festivalBonusesCount']}}</h2>
<h2>{{$data['otherBonusesCount']}}</h2>
<h2>{{$data['allPaidSalarySum']}}</h2>
<h2>{{$data['convenienceCount']}}</h2>
<h2>{{$data['allDueConveniencSum']}}</h2>
<h2>{{$data['allPaidConveniencSum']}}</h2>
@endsection



