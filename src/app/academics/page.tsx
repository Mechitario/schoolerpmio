'use client'

import React, { useState } from 'react'
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  Cell,
} from 'recharts'
import { GraduationCap, Search, FileText, Download, Award } from 'lucide-react'
import {
  DataTable,
  DataTableHeader,
  DataTableHeaderCell,
  DataTableBody,
  DataTableRow,
  DataTableCell,
  DataTableFooter,
} from '../../components/DataTable'

const CLASS_PERFORMANCE = [
  { class: 'Class 10', avg: 82, color: '#0ea5e9' },
  { class: 'Class 11', avg: 78, color: '#8b5cf6' },
  { class: 'Class 12', avg: 88, color: '#10b981' },
]

const academicData = [
  { id: '1', name: 'Arjun Verma', roll: '101', class: '10th', section: 'A', marks: 450, total: 500, percentage: 90, grade: 'A+' },
  { id: '2', name: 'Priya Singh', roll: '102', class: '10th', section: 'B', marks: 420, total: 500, percentage: 84, grade: 'A' },
  { id: '3', name: 'Rahul Dev', roll: '201', class: '12th', section: 'A', marks: 380, total: 500, percentage: 76, grade: 'B+' },
  { id: '4', name: 'Simran Kaur', roll: '205', class: '12th', section: 'C', marks: 475, total: 500, percentage: 95, grade: 'A+' },
  { id: '5', name: 'Aman Gupta', roll: '105', class: '10th', section: 'A', marks: 435, total: 500, percentage: 87, grade: 'A' },
  { id: '6', name: 'Lisa Ray', roll: '110', class: '11th', section: 'A', marks: 398, total: 500, percentage: 80, grade: 'A' },
]

const EXAM_TYPES = ['Final Exam', 'Mid Term', 'Unit Test 1', 'Unit Test 2']

export default function AcademicsPage() {
  const [examType, setExamType] = useState('Final Exam')
  const [searchTerm, setSearchTerm] = useState('')

  const filteredData = academicData.filter(
    (d) =>
      d.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      d.roll.includes(searchTerm)
  )

  const getGradeClass = (grade: string) => {
    if (grade === 'A+') return 'bg-emerald-100 text-emerald-700'
    if (grade === 'A') return 'bg-emerald-50 text-emerald-600'
    if (grade.startsWith('B')) return 'bg-primary-50 text-primary-600'
    return 'bg-slate-100 text-slate-600'
  }

  return (
    <div className="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
      <header className="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <h1 className="text-4xl font-black tracking-tight text-slate-900">Academics & Reports</h1>
          <p className="text-slate-500 mt-2 font-medium">Manage exam marks and generate student report cards.</p>
        </div>
        <div className="flex items-center gap-3">
          <button className="flex items-center gap-2 px-6 py-3 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-all active:scale-95">
            <Download size={18} className="text-slate-400" />
            Export All
          </button>
          <button className="flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-2xl shadow-xl shadow-primary-200 hover:bg-primary-700 transition-all active:scale-95">
            <FileText size={18} />
            Bulk Upload Marks
          </button>
        </div>
      </header>

      {/* Exam type tabs */}
      <div className="bg-white p-2 rounded-[2rem] shadow-[0_4px_24px_rgba(0,0,0,0.04)] border border-slate-200/60 flex gap-2 overflow-x-auto">
        {EXAM_TYPES.map((exam) => (
          <button
            key={exam}
            onClick={() => setExamType(exam)}
            className={`px-6 py-3 rounded-2xl text-sm font-bold whitespace-nowrap transition-all ${
              examType === exam
                ? 'bg-primary-600 text-white shadow-lg shadow-primary-200'
                : 'bg-slate-50 text-slate-600 hover:bg-slate-100'
            }`}
          >
            {exam}
          </button>
        ))}
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {/* Marks table */}
        <div className="lg:col-span-2 space-y-8">
          <div className="bg-white p-6 rounded-[2rem] shadow-[0_4px_24px_rgba(0,0,0,0.04)] border border-slate-200/60">
            <div className="relative group mb-6">
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-500 transition-colors" size={20} />
              <input
                type="text"
                placeholder="Search by name or roll number..."
                className="w-full pl-12 pr-4 py-3 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary-500/5 transition-all outline-none font-medium text-sm"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
            </div>

            <div className="mb-6 flex items-center justify-between">
              <h2 className="text-xl font-black text-slate-900">{examType} — Result Overview</h2>
            </div>

            {filteredData.length > 0 ? (
              <DataTable
                footer={
                  <DataTableFooter>
                    <p className="text-xs font-bold text-slate-400">
                      Showing {filteredData.length} of {academicData.length} students
                    </p>
                    <button className="text-xs font-bold text-primary-600 hover:underline">View all</button>
                  </DataTableFooter>
                }
              >
                <DataTableHeader>
                  <DataTableHeaderCell>Roll No.</DataTableHeaderCell>
                  <DataTableHeaderCell>Student</DataTableHeaderCell>
                  <DataTableHeaderCell>Class</DataTableHeaderCell>
                  <DataTableHeaderCell align="right">Marks</DataTableHeaderCell>
                  <DataTableHeaderCell align="right">%</DataTableHeaderCell>
                  <DataTableHeaderCell>Grade</DataTableHeaderCell>
                  <DataTableHeaderCell align="right">Report</DataTableHeaderCell>
                </DataTableHeader>
                <DataTableBody>
                  {filteredData.map((row) => (
                    <DataTableRow key={row.id}>
                      <DataTableCell>
                        <span className="font-bold text-slate-800">#{row.roll}</span>
                      </DataTableCell>
                      <DataTableCell>
                        <div className="flex items-center gap-3">
                          <div className="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden border-2 border-white shadow-sm flex-shrink-0">
                            <img src={`https://ui-avatars.com/api/?name=${encodeURIComponent(row.name)}&background=random`} alt="" className="w-full h-full object-cover" />
                          </div>
                          <span className="font-bold text-slate-800">{row.name}</span>
                        </div>
                      </DataTableCell>
                      <DataTableCell>
                        <span className="font-medium text-slate-600">{row.class}</span>
                        <span className="ml-1.5 px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded uppercase">{row.section}</span>
                      </DataTableCell>
                      <DataTableCell align="right">
                        <span className="font-black text-slate-900">{row.marks}</span>
                        <span className="text-slate-400 font-medium">/{row.total}</span>
                      </DataTableCell>
                      <DataTableCell align="right">
                        <span className="font-black text-slate-900">{row.percentage}%</span>
                      </DataTableCell>
                      <DataTableCell>
                        <span className={`inline-flex text-xs font-bold px-3 py-1.5 rounded-lg ${getGradeClass(row.grade)}`}>
                          {row.grade}
                        </span>
                      </DataTableCell>
                      <DataTableCell align="right">
                        <button className="inline-flex items-center gap-1 text-primary-600 text-sm font-bold hover:underline">
                          <Download size={14} />
                          Download
                        </button>
                      </DataTableCell>
                    </DataTableRow>
                  ))}
                </DataTableBody>
              </DataTable>
            ) : (
              <div className="py-16 text-center rounded-[1.25rem] border border-slate-200/60 bg-slate-50/50">
                <GraduationCap className="mx-auto text-slate-300 mb-4" size={48} />
                <p className="text-lg font-bold text-slate-600">No results found</p>
                <p className="text-sm text-slate-400 mt-1">Try a different search or exam type.</p>
              </div>
            )}
          </div>
        </div>

        {/* Right: Class performance chart + summary */}
        <div className="space-y-10">
          <div className="bg-white p-8 rounded-[2rem] border border-slate-200/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
            <h3 className="text-xl font-black text-slate-900 mb-6 flex items-center gap-2">
              <Award className="text-amber-500" size={24} />
              Class Performance
            </h3>
            <div className="h-[260px] w-full">
              <ResponsiveContainer width="100%" height="100%">
                <BarChart data={CLASS_PERFORMANCE} layout="vertical" margin={{ top: 10, right: 24, left: 0, bottom: 0 }}>
                  <CartesianGrid strokeDasharray="3 3" stroke="#e2e8f0" horizontal={false} />
                  <XAxis type="number" domain={[0, 100]} tick={{ fontSize: 11, fill: '#64748b', fontWeight: 600 }} axisLine={false} tickLine={false} tickFormatter={(v) => `${v}%`} />
                  <YAxis type="category" dataKey="class" tick={{ fontSize: 12, fill: '#0f172a', fontWeight: 700 }} axisLine={false} tickLine={false} width={72} />
                  <Tooltip
                    contentStyle={{ borderRadius: 12, border: '1px solid #e2e8f0', boxShadow: '0 4px 24px rgba(0,0,0,0.08)' }}
                    formatter={(value: number) => [`${value}% avg`, '']}
                  />
                  <Bar dataKey="avg" name="Average %" radius={[0, 8, 8, 0]} maxBarSize={32}>
                    {CLASS_PERFORMANCE.map((entry, index) => (
                      <Cell key={`cell-${index}`} fill={entry.color} />
                    ))}
                  </Bar>
                </BarChart>
              </ResponsiveContainer>
            </div>
          </div>

          <div className="bg-slate-900 p-8 rounded-[2rem] text-white shadow-2xl shadow-slate-200/50 relative overflow-hidden">
            <div className="relative z-10 flex flex-col items-center text-center">
              <div className="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mb-6">
                <GraduationCap size={32} className="text-primary-400" />
              </div>
              <h3 className="text-xl font-black mb-2">Academic Year 2025–26</h3>
              <p className="text-slate-400 text-sm font-medium leading-relaxed">
                Overall school pass rate is currently at <span className="text-white font-bold">94.2%</span> across all departments.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
