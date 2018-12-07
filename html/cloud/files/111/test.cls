VERSION 1.0 CLASS
BEGIN
  MultiUse = -1  'True
END
Attribute VB_Name = "Лист1"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = True


Private Sub test()
Dim strFN As String
strFN = ActiveWorkbook.Path + "\moodle.txt"

Open strFN For Output As #1

Dim k As Integer
Dim otv As String
For i = 10 To 1000
If Cells(i, 4).Value <> "" Then
If Left(Cells(i, 4).Value, 1) = " " Then
Cells(i, 4).Value = Right(Cells(i, 4).Value, Len(Cells(i, 4).Value) - 1)
End If

If Cells(i, 2).Value <> "" Then
    k = 1
    Rows(i).Insert Shift:=xlDown, CopyOrigin:=xlFormatFromLeftOrAbove
    If (otv <> "") Then
    Cells(i, 4).Value = "Ответ: " + otv
    End If
    i = i + 1
    Rows(i).Insert Shift:=xlDown, CopyOrigin:=xlFormatFromLeftOrAbove
    i = i + 1
Else
    Cells(i, 4).Value = CStr(k) + ". " + Cells(i, 4).Value
    If (Cells(i, 3).Value = "Y") Then
    otv = CStr(k)
    End If
    k = k + 1
End If
End If
Next

For i = 13 To 1000
Print #1, Cells(i, 4).Value
Next

Close #1
End Sub
