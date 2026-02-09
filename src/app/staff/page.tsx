'use client'

import React, { useState } from 'react'
import { UserCog, Plus, Search, Mail, Phone, Briefcase, DollarSign, Download, MoreHorizontal } from 'lucide-react'
import {
  DataTable,
  DataTableHeader,
  DataTableHeaderCell,
  DataTableBody,
  DataTableRow,
  DataTableCell,
  DataTableFooter,
} from '../../components/DataTable'

const staffList = [
  { id: '1', name: 'Dr. Ramesh Kumar', role: 'Principal', department: 'Administration', salary: 5000, joined: 'Jan 2020', email: 'ramesh.k@school.com', status: 'Active' as const },
  { id: '2', name: 'Ms. Anita Sharma', role: 'Senior Teacher', department: 'Mathematics', salary: 3200, joined: 'July 2022', email: 'anita.s@school.com', status: 'Active' as const },
  { id: '3', name: 'Mr. Sunil Gupta', role: 'Accountant', department: 'Finance', salary: 2800, joined: 'Mar 2021', email: 'sunil.g@school.com', status: 'Active' as const },
  { id: '4', name: 'Ms. Deepa Rani', role: 'Teacher', department: 'Science', salary: 2500, joined: 'Oct 2023', email: 'deepa.r@school.com', status: 'Active' as const },
  { id: '5', name: 'Mr. Vikram Singh', role: 'PE Teacher', department: 'Sports', salary: 2400, joined: 'Aug 2022', email: 'vikram.s@school.com', status: 'Active' as const },
  { id: '6', name: 'Mrs. Kavita Nair', role: 'Vice Principal', department: 'Administration', salary: 4200, joined: 'Jan 2019', email: 'kavita.n@school.com', status: 'Active' as const },
]

export default function StaffPage() {
  const [searchTerm, setSearchTerm] = useState('')
  const [departmentFilter, setDepartmentFilter] = useState('All')

  const departments = ['All', ...Array.from(new Set(staffList.map((s) => s.department)))]

  const filteredStaff = staffList.filter((s) => {
    const matchSearch =
      s.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      s.role.toLowerCase().includes(searchTerm.toLowerCase()) ||
      s.email.toLowerCase().includes(searchTerm.toLowerCase())
    const matchDept = departmentFilter === 'All' || s.department === departmentFilter
    return matchSearch && matchDept
  })

  const totalSalary = staffList.reduce((a, b) => a + b.salary, 0)
  const teachingCount = staffList.filter((s) => s.department !== 'Finance' && s.department !== 'Administration').length
  const adminCount = staffList.length - teachingCount

  return (
    <div className="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
      <header className="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <h1 className="text-4xl font-black tracking-tight text-slate-900">Staff Management</h1>
          <p className="text-slate-500 mt-2 font-medium">Manage teachers, administrators, and staff salaries.</p>
        </div>
        <div className="flex items-center gap-3">
          <button className="flex items-center gap-2 px-6 py-3 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-all active:scale-95">
            <DollarSign size={18} className="text-slate-400" />
            Pay Salaries
          </button>
          <button className="flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-2xl shadow-xl shadow-primary-200 hover:bg-primary-700 transition-all active:scale-95">
            <Plus size={18} />
            Add Staff
          </button>
        </div>
      </header>

      {/* Summary cards */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div className="bg-white p-7 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 flex items-center gap-5">
          <div className="w-14 h-14 rounded-2xl bg-primary-100 flex items-center justify-center text-primary-600">
            <UserCog size={24} />
          </div>
          <div>
            <p className="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Total Staff</p>
            <p className="text-2xl font-black text-slate-900 mt-1">{staffList.length}</p>
          </div>
        </div>
        <div className="bg-white p-7 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 flex items-center gap-5">
          <div className="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
            <Briefcase size={24} />
          </div>
          <div>
            <p className="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Teaching</p>
            <p className="text-2xl font-black text-slate-900 mt-1">{teachingCount}</p>
          </div>
        </div>
        <div className="bg-white p-7 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 flex items-center gap-5">
          <div className="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600">
            <UserCog size={24} />
          </div>
          <div>
            <p className="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Admin / Other</p>
            <p className="text-2xl font-black text-slate-900 mt-1">{adminCount}</p>
          </div>
        </div>
        <div className="bg-white p-7 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 flex items-center gap-5">
          <div className="w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-600">
            <DollarSign size={24} />
          </div>
          <div>
            <p className="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Monthly Payout</p>
            <p className="text-2xl font-black text-rose-600 mt-1">${totalSalary.toLocaleString()}</p>
          </div>
        </div>
      </div>

      {/* Filters */}
      <div className="bg-white p-6 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 flex flex-col md:flex-row gap-4">
        <div className="relative flex-1 group">
          <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-500 transition-colors" size={20} />
          <input
            type="text"
            placeholder="Search by name, role or email..."
            className="w-full pl-12 pr-4 py-3 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary-500/5 transition-all outline-none font-medium text-sm"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
        </div>
        <div className="flex gap-3">
          <select
            value={departmentFilter}
            onChange={(e) => setDepartmentFilter(e.target.value)}
            className="min-w-[160px] bg-slate-50 border-transparent rounded-2xl px-5 py-3 focus:bg-white focus:ring-4 focus:ring-primary-500/5 transition-all outline-none font-bold text-sm text-slate-700"
          >
            {departments.map((d) => (
              <option key={d} value={d}>
                {d === 'All' ? 'All Departments' : d}
              </option>
            ))}
          </select>
        </div>
      </div>

      {/* Staff table */}
      <div className="bg-white p-8 rounded-[2rem] border border-slate-200/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        <div className="flex items-center justify-between mb-8">
          <h2 className="text-2xl font-black text-slate-900">Staff Directory</h2>
          <button className="flex items-center gap-2 text-primary-600 text-sm font-bold hover:underline">
            <Download size={16} />
            Export list
          </button>
        </div>

        {filteredStaff.length > 0 ? (
          <DataTable
            footer={
              <DataTableFooter>
                <p className="text-xs font-bold text-slate-400">
                  Showing {filteredStaff.length} of {staffList.length} staff
                </p>
                <div className="flex gap-2">
                  <button className="px-4 py-2 text-xs font-bold text-slate-400 bg-white border border-slate-200 rounded-xl cursor-not-allowed">Previous</button>
                  <button className="px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">Next</button>
                </div>
              </DataTableFooter>
            }
          >
            <DataTableHeader>
              <DataTableHeaderCell>Staff</DataTableHeaderCell>
              <DataTableHeaderCell>Role</DataTableHeaderCell>
              <DataTableHeaderCell>Department</DataTableHeaderCell>
              <DataTableHeaderCell>Joined</DataTableHeaderCell>
              <DataTableHeaderCell align="right">Salary</DataTableHeaderCell>
              <DataTableHeaderCell>Status</DataTableHeaderCell>
              <DataTableHeaderCell align="right">Actions</DataTableHeaderCell>
            </DataTableHeader>
            <DataTableBody>
              {filteredStaff.map((member) => (
                <DataTableRow key={member.id}>
                  <DataTableCell>
                    <div className="flex items-center gap-4">
                      <div className="w-12 h-12 rounded-2xl bg-slate-100 overflow-hidden border-2 border-white shadow-sm flex-shrink-0 flex items-center justify-center text-slate-600">
                        <UserCog size={24} />
                      </div>
                      <div>
                        <p className="font-black text-slate-800">{member.name}</p>
                        <p className="text-xs font-medium text-slate-400 flex items-center gap-1">
                          <Mail size={10} /> {member.email}
                        </p>
                      </div>
                    </div>
                  </DataTableCell>
                  <DataTableCell>
                    <span className="font-bold text-slate-700">{member.role}</span>
                  </DataTableCell>
                  <DataTableCell>
                    <span className="px-3 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg uppercase tracking-wider">{member.department}</span>
                  </DataTableCell>
                  <DataTableCell>
                    <span className="font-medium text-slate-600">{member.joined}</span>
                  </DataTableCell>
                  <DataTableCell align="right">
                    <span className="font-black text-slate-900">${member.salary.toLocaleString()}</span>
                  </DataTableCell>
                  <DataTableCell>
                    <span className="inline-flex items-center gap-1.5 text-[10px] font-bold px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700">
                      <span className="w-1.5 h-1.5 rounded-full bg-emerald-500" />
                      {member.status}
                    </span>
                  </DataTableCell>
                  <DataTableCell align="right">
                    <div className="flex items-center justify-end gap-2">
                      <button className="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all" title="Email">
                        <Mail size={18} />
                      </button>
                      <button className="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all" title="Call">
                        <Phone size={18} />
                      </button>
                      <button className="p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-all">
                        <MoreHorizontal size={18} />
                      </button>
                    </div>
                  </DataTableCell>
                </DataTableRow>
              ))}
            </DataTableBody>
          </DataTable>
        ) : (
          <div className="py-16 text-center rounded-[1.25rem] border border-slate-200/60 bg-slate-50/50">
            <UserCog className="mx-auto text-slate-300 mb-4" size={48} />
            <p className="text-lg font-bold text-slate-600">No staff found</p>
            <p className="text-sm text-slate-400 mt-1">Try a different search or department.</p>
          </div>
        )}
      </div>
    </div>
  )
}
