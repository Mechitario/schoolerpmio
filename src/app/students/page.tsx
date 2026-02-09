'use client'

import React, { useState } from 'react'
import { Plus, Search, Filter, MoreVertical, UserPlus, ChevronDown, Download, Mail, Phone, MoreHorizontal } from 'lucide-react'

export default function StudentsPage() {
  const [selectedClass, setSelectedClass] = useState('All')

  const students = [
    { id: '1', name: 'Arjun Verma', email: 'arjun.v@gmail.com', roll: '101', class: '10th', section: 'A', status: 'Active', parent: 'Vijay Verma' },
    { id: '2', name: 'Priya Singh', email: 'priya.s@yahoo.com', roll: '102', class: '10th', section: 'B', status: 'Active', parent: 'Sanjay Singh' },
    { id: '3', name: 'Rahul Dev', email: 'rahul.d@outlook.com', roll: '201', class: '12th', section: 'A', status: 'Inactive', parent: 'Rakesh Dev' },
    { id: '4', name: 'Simran Kaur', email: 'simran.k@gmail.com', roll: '205', class: '12th', section: 'C', status: 'Active', parent: 'Harpreet Kaur' },
    { id: '5', name: 'Aman Gupta', email: 'aman.g@gmail.com', roll: '105', class: '10th', section: 'A', status: 'Active', parent: 'Suresh Gupta' },
  ]

  const filteredStudents = selectedClass === 'All' 
    ? students 
    : students.filter(s => s.class === selectedClass)

  return (
    <div className="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
      <header className="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
          <h1 className="text-4xl font-black tracking-tight text-slate-900">Student Directory</h1>
          <p className="text-slate-500 mt-2 font-medium">Manage and monitor student records across all classes.</p>
        </div>
        <div className="flex items-center gap-3 w-full md:w-auto">
          <button className="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-3 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-all active:scale-95">
            <Download size={18} className="text-slate-400" />
            Export List
          </button>
          <button className="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-2xl shadow-xl shadow-primary-200 hover:bg-primary-700 hover:shadow-primary-300 transition-all active:scale-95">
            <UserPlus size={18} />
            Add Student
          </button>
        </div>
      </header>

      {/* Filters & Search */}
      <div className="bg-white p-6 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 flex flex-col md:flex-row gap-4">
        <div className="relative flex-1 group">
          <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-500 transition-colors" size={20} />
          <input 
            type="text" 
            placeholder="Search by name, email, roll number..." 
            className="w-full pl-12 pr-4 py-3 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-primary-200 focus:ring-4 focus:ring-primary-500/5 transition-all outline-none font-medium text-sm"
          />
        </div>
        <div className="flex gap-3">
          <div className="relative min-w-[160px]">
            <select 
              value={selectedClass} 
              onChange={(e) => setSelectedClass(e.target.value)}
              className="w-full appearance-none bg-slate-50 border-transparent rounded-2xl px-5 py-3 pr-10 focus:bg-white focus:border-primary-200 focus:ring-4 focus:ring-primary-500/5 transition-all outline-none font-bold text-sm text-slate-700 cursor-pointer"
            >
              <option value="All">All Classes</option>
              <option value="10th">Class 10th</option>
              <option value="11th">Class 11th</option>
              <option value="12th">Class 12th</option>
            </select>
            <ChevronDown className="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" size={16} />
          </div>
          <button className="flex items-center gap-2 px-5 py-3 bg-slate-50 text-slate-700 font-bold rounded-2xl hover:bg-slate-100 transition-all">
            <Filter size={18} className="text-slate-400" />
            Filters
          </button>
        </div>
      </div>

      {/* Students Table */}
      <div className="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="border-b border-slate-100 bg-slate-50/50">
                <th className="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Student</th>
                <th className="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Roll No.</th>
                <th className="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Class / Section</th>
                <th className="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Parent Name</th>
                <th className="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                <th className="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Actions</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {filteredStudents.map((student) => (
                <tr key={student.id} className="group hover:bg-slate-50/80 transition-all duration-300">
                  <td className="p-6">
                    <div className="flex items-center gap-4">
                      <div className="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center overflow-hidden border-2 border-white shadow-sm group-hover:scale-110 transition-transform">
                        <img src={`https://ui-avatars.com/api/?name=${student.name}&background=random`} alt={student.name} />
                      </div>
                      <div className="flex flex-col">
                        <span className="text-sm font-black text-slate-800 tracking-tight">{student.name}</span>
                        <span className="text-[11px] font-bold text-slate-400 flex items-center gap-1">
                          <Mail size={10} /> {student.email}
                        </span>
                      </div>
                    </div>
                  </td>
                  <td className="p-6 text-sm font-bold text-slate-600">
                    <span className="bg-slate-100 px-3 py-1 rounded-lg">#{student.roll}</span>
                  </td>
                  <td className="p-6">
                    <div className="flex items-center gap-2">
                      <span className="text-sm font-black text-slate-800">{student.class}</span>
                      <span className="w-6 h-6 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-[10px] font-black">{student.section}</span>
                    </div>
                  </td>
                  <td className="p-6 text-sm font-bold text-slate-600">{student.parent}</td>
                  <td className="p-6">
                    <span className={`inline-flex items-center gap-1.5 text-[10px] font-black px-3 py-1.5 rounded-full ${
                      student.status === 'Active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'
                    }`}>
                      <span className={`w-1.5 h-1.5 rounded-full ${student.status === 'Active' ? 'bg-emerald-500' : 'bg-rose-500'}`}></span>
                      {student.status.toUpperCase()}
                    </span>
                  </td>
                  <td className="p-6 text-right">
                    <div className="flex items-center justify-end gap-2">
                      <button className="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all">
                        <Mail size={18} />
                      </button>
                      <button className="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all">
                        <Phone size={18} />
                      </button>
                      <button className="p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-all">
                        <MoreHorizontal size={18} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
        
        {filteredStudents.length === 0 && (
          <div className="p-20 text-center">
            <div className="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
              <Search size={32} className="text-slate-300" />
            </div>
            <h3 className="text-xl font-black text-slate-800">No students found</h3>
            <p className="text-slate-400 mt-2 font-medium">Try adjusting your filters or search terms.</p>
            <button 
              onClick={() => setSelectedClass('All')}
              className="mt-6 text-primary-600 font-black text-sm hover:underline"
            >
              Clear all filters
            </button>
          </div>
        )}

        <div className="p-6 border-t border-slate-100 bg-slate-50/30 flex items-center justify-between">
          <p className="text-xs font-bold text-slate-400">Showing <span className="text-slate-800">{filteredStudents.length}</span> of <span className="text-slate-800">{students.length}</span> students</p>
          <div className="flex gap-2">
            <button className="px-4 py-2 text-xs font-bold text-slate-400 bg-white border border-slate-200 rounded-xl cursor-not-allowed">Previous</button>
            <button className="px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">Next</button>
          </div>
        </div>
      </div>
    </div>
  )
}
